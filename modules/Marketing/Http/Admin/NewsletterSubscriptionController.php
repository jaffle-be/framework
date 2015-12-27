<?php

namespace Modules\Marketing\Http\Admin;

use Drewm\MailChimp;
use Illuminate\Http\Request;
use Modules\System\Http\FrontController;

/**
 * Class NewsletterSubscriptionController
 * @package Modules\Marketing\Http\Admin
 */
class NewsletterSubscriptionController extends FrontController
{
    /**
     * @param MailChimp $mailChimp
     * @param Request $request
     * @return array
     */
    public function index(MailChimp $mailChimp, Request $request)
    {
        try {
            $result = $mailChimp->call('lists/members', [
                'id' => env('MAILCHIMP_DEFAULT_LIST_ID'),
                'opts' => [
                    'start' => $request->get('page', 1) - 1,
                    //default limit is 25
                    'limit' => 25,
                ],
                'status' => $request->get('filter', 'subscribed'),
            ]);

            return $result;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
