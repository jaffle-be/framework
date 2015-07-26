<?php

namespace App\Account\Http\Admin;

use App\Account\AccountContactInformation;
use App\Account\AccountManager;
use App\Account\Jobs\Contact\UpdateInformation;
use App\Account\Requests\Contact\UpdateInformationRequest;
use App\Http\Controllers\AdminController;

class ContactController extends AdminController
{

    public function page(AccountManager $manager)
    {
        $account = $manager->account();

        $account->load(['contactInformation', 'contactInformation.address']);

        $contact = $account->contactInformation->first();

        if(!$contact)
        {
            $contact = $account->contactInformation()->create([]);
        }

        $address = $contact ? $contact->address : null;

        return view('account::contact.settings', ['account' => $account, 'contact' => $contact, 'address' => $address]);
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

        $account->load(['contactInformation', 'contactInformation.translations']);

        $contact = $account->contactInformation->first();

        return $contact;
    }

    public function update(AccountContactInformation $accountContactInformation, UpdateInformationRequest $request)
    {
        $accountContactInformation->load('translations');

        $response = $this->dispatchFromArray(UpdateInformation::class, [
            'info' => $accountContactInformation,
            'input' => translation_input($request, array_merge(['_token'], ['form_description', 'widget_title', 'widget_content']))
        ]);
    }

}