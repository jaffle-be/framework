<?php

namespace Modules\Account\Http\Admin;

use Modules\Account\AccountContactInformation;
use Modules\Account\AccountManager;
use Modules\Account\Jobs\Contact\UpdateInformation;
use Modules\Account\Requests\Contact\UpdateInformationRequest;
use Modules\System\Http\AdminController;

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
        $response = $this->dispatch(new UpdateInformation($accountContactInformation, translation_input($request)));

        $manager->updated();
    }
}
