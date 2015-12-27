<?php namespace Modules\Marketing\Jobs;

use App\Jobs\Job;
use Drewm\MailChimp;
use Exception;

use Modules\Marketing\Newsletter\Campaign;
use Modules\Marketing\Newsletter\CampaignBuilder;
use Modules\Marketing\Newsletter\CampaignConfig;
use Symfony\Component\HttpKernel\Exception\HttpException;

class StartNewsletterCampaign extends Job
{

    protected $campaign;

    protected $locale;

    public function __construct(Campaign $campaign, $locale)
    {
        $this->campaign = $campaign;
        $this->locale = $locale;
    }

    public function handle(MailChimp $mailChimp, CampaignConfig $config, CampaignBuilder $builder)
    {
        $campaign = $this->campaign->translate($this->locale);

        try {
            $content = $builder->build($this->campaign, $this->locale);
        }
        catch (Exception $e) {
            throw new HttpException(400, 'There was a problem, check for any unfinished widgets', null, ['reason' => 'There was a problem, check for any unfinished widgets']);
        }

        try {
            $result = $mailChimp->call('campaigns/create', [
                'type'    => 'regular',
                'options' => [
                    'list_id'    => env('MAILCHIMP_DEFAULT_LIST_ID'),
                    'subject'    => $campaign->subject,
                    'from_email' => $config->fromEmail(),
                    'from_name'  => $config->fromName(),
                    'to_name'    => $config->toName(),
                    'title'      => $campaign->title,

                ],
                'content' => [
                    'html' => $content,
                ]
            ]);

            if ($result && isset($result['id'])) {
                $campaign->mail_chimp_campaign_id = $result['id'];

                return $campaign->save() ? $campaign : false;
            }
        }
        catch (Exception $e) {
            throw new HttpException(400, 'Cannot contact mailservice, try again later', null, ['reason' => 'Cannot contact mailservice, try again later']);
        }
    }

}