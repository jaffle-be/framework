<?php

namespace App\Account\Http\Admin;

use App\Account\AccountContactInformation;
use App\Account\AccountManager;
use App\Account\Jobs\Contact\UpdateInformation;
use App\Account\Requests\Contact\UpdateInformationRequest;
use App\System\Http\AdminController;

class ContactController extends AdminController
{

    public function page(AccountManager $manager)
    {
        $account = $manager->account();

        $contact = $account->contactInformation->first();

        $address = $contact ? $contact->address : null;

        return view('account::admin.contact.settings', ['contact' => $contact, 'address' => $address]);
    }

    /**
     * Index is the show method here, but we don't need an id to provide it.
     *
     * @param AccountManager $manager
     *
     * @return mixed
     */
    public function index(AccountManager $manager)
    {
        $account = $manager->account();

        return $account->contactInformation->first();
    }

    public function update(AccountContactInformation $accountContactInformation, UpdateInformationRequest $request, AccountManager $manager)
    {
        $response = $this->dispatchFromArray(UpdateInformation::class, [
            'info'  => $accountContactInformation,
            'input' => translation_input($request, [])
        ]);

        $manager->updated();
    }

}