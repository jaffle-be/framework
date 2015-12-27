<?php

namespace Modules\Marketing\Http\Admin;

use Drewm\MailChimp;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Modules\Account\AccountManager;
use Modules\Blog\BlogSearch;
use Modules\Blog\Post;
use Modules\Marketing\Jobs\Newsletter\UpdateCampaign;
use Modules\Marketing\Jobs\StartNewsletterCampaign;
use Modules\Marketing\Newsletter\Campaign;
use Modules\Marketing\Newsletter\CampaignBuilder;
use Modules\Marketing\Newsletter\ReportFormatter;
use Modules\Portfolio\PortfolioSearch;
use Modules\Portfolio\Project;
use Modules\Search\SearchServiceInterface;
use Modules\System\Http\AdminController;

class NewsletterCampaignController extends AdminController
{

    use BlogSearch;
    use PortfolioSearch;

    public function index(Request $request)
    {
        $query = Campaign::with(['translations']);

        $value = $request->get('query');
        $locale = $request->get('locale');

        if (!empty($value)) {
            $query->whereHas('translations', function ($q) use ($value, $locale) {
                $q->where('locale', $locale);
                $q->where('title', 'like', '%' . $value . '%');
            });
        }

        return $query->paginate();
    }

    public function subscriptions(MailChimp $mailChimp, Request $request)
    {
        try {
            $result = $mailChimp->call('lists/members', [
                'id' => env('MAILCHIMP_DEFAULT_LIST_ID'),
                'opts' => [
                    'start' => $request->get('page', 1) - 1,
                    //default limit is 25
                    'limit' => 25,
                ],
            ]);

            return $result;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function store(Request $request, Campaign $newsletter, Guard $guard, AccountManager $accounts)
    {
        $input = translation_input($request);

        $newsletter = $newsletter->newInstance($input);

        $newsletter->account_id = $accounts->account()->id;

        $newsletter->user()->associate($guard->user());

        if ($newsletter->save()) {
            return $newsletter;
        }

        return json_encode(array(
            'status' => 'noke',
        ));
    }

    public function show(Campaign $newsletter, CampaignBuilder $builder, MailChimp $mailChimp)
    {
        return $this->detailedResponse($newsletter, $builder, $mailChimp);
    }

    public function update(Campaign $newsletter, Request $request)
    {
        $newsletter->load($this->relations());

        if (!$this->dispatch(new UpdateCampaign($newsletter, translation_input($request, ['title', 'content', 'publish_at'])))) {
            return response('500', 'something bad happened');
        }

        return $newsletter;
    }

    public function destroy(Campaign $newsletter)
    {
        if ($newsletter->delete()) {
            $newsletter->id = false;
        }

        return $newsletter;
    }

    public function batchDestroy(Request $request, Campaign $newsletter)
    {
        $ids = $request->get('campaigns', []);

        if (is_array($ids) && count($ids)) {
            $newsletters = $newsletter->whereIn('newsletter_campaigns.id', $ids)
                ->get();

            foreach ($newsletters as $newsletter) {
                $newsletter->delete();
            }
        }
    }

    public function search(Request $request, AccountManager $manager, SearchServiceInterface $search)
    {
        $this->validate($request, [
            'query' => 'required',
            'locale' => 'required',
        ]);

        //we want to be able to select any of the following:
        // - product
        // - post
        // - project
        // - maybe even a page?

        $query = $this->postsQuery($request, $manager, $request->get('locale'));

        $posts = $search->search('posts', $query, [], false);

        $query = $this->projectsQuery($request, $manager, $request->get('locale'));

        $projects = $search->search('projects', $query, [], false);

        $result = new Collection();

        foreach ($posts as $post) {
            $result->push([
                'label' => 'post: ' . $post->translate($request->get('locale'))->title,
                'type' => Post::class,
                'value' => $post->id,
            ]);
        }

        foreach ($projects as $project) {
            $result->push([
                'label' => 'project: ' . $project->translate($request->get('locale'))->title,
                'type' => Project::class,
                'value' => $project->id,
            ]);
        }

        return $result;
    }

    public function overview()
    {
        return view('marketing::admin.newsletter.overview');
    }

    public function detail(CampaignBuilder $builder)
    {
        return view('marketing::admin.newsletter.detail', ['widgets' => $builder->getAvailableWidgets()]);
    }

    protected function relations()
    {
        return [
            'images',
            'images.sizes',
            'translations',
            'widgets',
            'widgets.image',
            'widgets.imageLeft',
            'widgets.imageRight',
            'widgets.resource',
            'widgets.otherResource',
            'widgets.translations',
        ];
    }

    public function prepare(Request $request, Campaign $campaign, CampaignBuilder $builder, MailChimp $mailchimp)
    {
        $this->validate($request, [
            'locale' => 'required',
        ]);

        $this->dispatch(new StartNewsletterCampaign($campaign, $request->get('locale')));

        return $this->detailedResponse($campaign, $builder, $mailchimp);
    }

    public function send(Request $request, Campaign $campaign, MailChimp $mailChimp)
    {
        $this->validate($request, [
            'locale' => 'required',
        ]);

        $result = $mailChimp->call('campaigns/send', [
            'cid' => $campaign->translate($request->get('locale'))->mail_chimp_campaign_id,
        ]);

        $translation = $campaign->translate($request->get('locale'));

        return $this->getReportSummary($mailChimp, $translation);
    }

    /**
     *
     */
    protected function loadMailchimpDataForCampaign(MailChimp $mailChimp, $translation)
    {
        $translation->mailchimp = $mailChimp->call('campaigns/ready', [
            'cid' => $translation->mail_chimp_campaign_id,
        ]);

        $translation->preview = $mailChimp->call('campaigns/content', [
            'cid' => $translation->mail_chimp_campaign_id,
        ]);

        $translation->summary = $this->getReportSummary($mailChimp, $translation);
    }

    /**
     * @return array
     */
    protected function detailedResponse(Campaign $newsletter, CampaignBuilder $builder, MailChimp $mailChimp)
    {
        $newsletter->load($this->relations());

        $newsletter->availableWidgets = $builder->getAvailableWidgets();

        //we need to check each locale if it's been linked to a campaign.
        //if so, we'll need to hook that campaign data onto the response.
        foreach ($newsletter->translations as $translation) {
            if ($translation->mail_chimp_campaign_id) {
                $this->loadMailchimpDataForCampaign($mailChimp, $translation);
            }
        }

        return $newsletter->toArray();
    }

    /**
     * @return array
     */
    protected function getReportSummary(MailChimp $mailChimp, $translation)
    {
        $result = $mailChimp->call('reports/summary', [
            'cid' => $translation->mail_chimp_campaign_id,
        ]);

        $reportFormatter = new ReportFormatter();

        return $reportFormatter->format($result);
    }
}
