<?php namespace App\Contact\Http;

use App\Account\AccountManager;
use App\Contact\Jobs\SendContactEmail;
use App\Contact\Requests\ContactRequest;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Session\Store;

class ContactController extends Controller{

    use DispatchesJobs;

    public function index(AccountManager $manager, Store $session)
    {
        $account = $manager->account();

        $account->load([
            'contactInformation',
            'contactInformation.address'
        ]);

        $contact = $account->contactInformation->first();

        $success = $session->get('success');

        return $this->theme->render('contact.contact-advanced', ['contact' => $contact, 'success' => $success]);
    }

    public function store(ContactRequest $request, AccountManager $account)
    {
        $account = $account->account();

        //if we have an advanced form, we also have the parameters subject, and copy
        $this->dispatchFromArray(SendContactEmail::class, [
            'contact' => $account->contactInformation->find($request->get('_id')),
            'email' => $request->get('email'),
            'name' => $request->get('name'),
            'message' => $request->get('message'),
            'subject' => $request->get('subject', null),
            'copy' => $request->get('copy', null)
        ]);

        return redirect()->back()->withSuccess(true);
    }

}