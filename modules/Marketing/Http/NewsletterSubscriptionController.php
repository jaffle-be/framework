<?php

namespace Modules\Marketing\Http;

use Drewm\MailChimp;
use Illuminate\Http\Request;
use Modules\System\Http\FrontController;

/**
 * Class NewsletterSubscriptionController
 * @package Modules\Marketing\Http
 */
class NewsletterSubscriptionController extends FrontController
{
    /**
     * @param Request $request
     * @param MailChimp $mailChimp
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, MailChimp $mailChimp)
    {
        $this->validate($request, ['email' => 'required|email']);

        try {
            $mailChimp->call('lists/subscribe', [
                'id' => env('MAILCHIMP_DEFAULT_LIST_ID'),
                'email' => ['email' => $request->get('email')],
                'double_optin' => false,
                'update_existing' => true,
                'replace_interests' => false,
                'send_welcome' => false,
            ]);

            return redirect()->back()->with('newsletter.subscription', 'success');
        } catch (\Exception $e) {
            app('log')->error('newsletter', [
                'route' => 'store.newsletter.store',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);
        }

        return redirect()->back()->with('newsletter.subscription', 'failed');
    }
}
