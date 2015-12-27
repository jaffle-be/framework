<?php namespace Modules\Contact\Http;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Session\Store;
use Modules\Account\AccountManager;
use Modules\Contact\Jobs\SendContactEmail;
use Modules\Contact\Requests\ContactRequest;
use Modules\System\Http\FrontController;

class ContactController extends FrontController
{

    use DispatchesJobs;

    public function index(AccountManager $manager, Store $session)
    {
        $account = $manager->account();

        $contact = $account->contactInformation->first();

        $success = $session->get('success');

        return $this->theme->render('contact.' . $this->theme->setting('contactLayout'), ['contact' => $contact, 'success' => $success]);
    }

    public function store(ContactRequest $request, AccountManager $account)
    {
        $account = $account->account();

        $contact = $account->contactInformation->find($request->get('_id'));

        //if we have an advanced form, we also have the parameters subject, and copy
        $this->dispatch(new SendContactEmail($contact, $request->get('name'), $request->get('email'),  $request->get('message'),  $request->get('subject', null), $request->get('copy', null)));

        return redirect()->back()->withSuccess(true);
    }

}