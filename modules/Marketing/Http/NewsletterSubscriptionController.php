<?php namespace Modules\Marketing\Http;

use Drewm\MailChimp;
use Illuminate\Http\Request;
use Modules\System\Http\FrontController;

class NewsletterSubscriptionController extends FrontController
{

    public function store(Request $request, MailChimp $mailChimp)
    {
        $this->validate($request, ['email' => 'required|email']);

        try {

            $mailChimp->call('lists/subscribe', array(
                'id'                => env('MAILCHIMP_DEFAULT_LIST_ID'),
                'email'             => array('email' => $request->get('email')),
                'double_optin'      => false,
                'update_existing'   => true,
                'replace_interests' => false,
                'send_welcome'      => false,
            ));

            return redirect()->back()->with('newsletter.subscription', 'success');
        }
        catch (\Exception $e) {
            app('log')->error('newsletter', [
                'route'   => 'store.newsletter.store',
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile()
            ]);
        }

        return redirect()->back()->with('newsletter.subscription', 'failed');
    }

}