<?php namespace Modules\Marketing\Jobs;

use App\Jobs\Job;
use Carbon\Carbon;
use Drewm\MailChimp;
use Illuminate\Contracts\Bus\SelfHandling;
use Modules\Marketing\Newsletter\CampaignBuilder;
use Modules\Marketing\Newsletter\CampaignConfig;

class StartNewsletterCampaign extends Job implements SelfHandling
{
    protected $list;

    protected $title;

    protected $subject;

    public function __construct($listid, $title, $subject)
    {
        $this->list = $listid;
        $this->title = 'new campaign title';
        $this->subject = 'test_campaign_app_' . Carbon::now()->getTimestamp();
    }

    public function handle(MailChimp $mailChimp, CampaignConfig $config, CampaignBuilder $builder)
    {
        try {
            $result = $mailChimp->call('campaigns/create', [
                'type'    => 'regular',
                'options' => [
                    'list_id'    => $this->list,
                    'subject'    => $this->subject,
                    'from_email' => $config->fromEmail(),
                    'from_name'  => $config->fromName(),
                    'to_name'    => $config->toName(),
                    'title'      => $this->title,

                ],
                'content' => [
                    'html' => $builder->build(),
                ]
            ]);
        }
        catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

}