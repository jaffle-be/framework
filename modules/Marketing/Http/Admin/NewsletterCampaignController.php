<?php namespace Modules\Marketing\Http\Admin;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Modules\Account\AccountManager;
use Modules\Blog\BlogSearch;
use Modules\Blog\Post;
use Modules\Marketing\Jobs\Newsletter\UpdateCampaign;
use Modules\Marketing\Newsletter\Campaign;
use Modules\Marketing\Newsletter\CampaignBuilder;
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
            'status' => 'noke'
        ));
    }

    public function show(Campaign $newsletter, CampaignBuilder $builder)
    {
        $newsletter->load($this->relations());

        $newsletter->availableWidgets = $builder->getAvailableWidgets();

        return $newsletter->toArray();
    }

    public function update(Campaign $newsletter, Request $request)
    {
        $newsletter->load($this->relations());

        $payload = [
            'newsletter'  => $newsletter,
            'input' => translation_input($request, ['title', 'content', 'publish_at'])
        ];

        if (!$this->dispatchFromArray(UpdateCampaign::class, $payload)) {
            return response('500', 'something bad happened');
        }

        return $newsletter;
    }

    public function destroy(Campaign $newsletter)
    {
        if($newsletter->delete())
        {
            $newsletter->id = false;
        }

        return $newsletter;
    }

    public function batchDestroy(Request $request, Campaign $newsletter)
    {
        $ids = $request->get('newsletters', []);

        if(is_array($ids) && count($ids))
        {
            $newsletters = $newsletter->whereIn('newsletters.id', $ids)
                ->get();

            foreach($newsletters as $newsletter)
            {
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

        foreach($posts as $post)
        {
            $result->push([
                'label' => 'post: ' . $post->translate($request->get('locale'))->title,
                'type' => Post::class,
                'value' => $post->id
            ]);
        }

        foreach($projects as $project)
        {
            $result->push([
                'label' => 'project: ' . $project->translate($request->get('locale'))->title,
                'type' => Project::class,
                'value' => $project->id
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
            'images', 'images.sizes', 'translations',
            'widgets', 'widgets.image', 'widgets.leftImage', 'widgets.rightImage',
            'widgets.resource', 'widgets.otherResource',
            'widgets.translations'
        ];
    }


}