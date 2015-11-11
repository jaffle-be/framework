<?php namespace Modules\Marketing\Newsletter;

use Drewm\MailChimp;

class SubscriptionList
{

    protected $mailChimp;

    public function __construct(MailChimp $mailChimp)
    {
        $this->mailChimp = $mailChimp;
    }

    public function members()
    {
        $members = $this->mailChimp->call('lists/members', ['id' => env('MAILCHIMP_DEFAULT_LIST_ID')]);

        print_r($members);
    }

}