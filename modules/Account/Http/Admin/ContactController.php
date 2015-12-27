<?php

namespace Modules\Account\Http\Admin;

use Modules\Account\AccountContactInformation;
use Modules\Account\AccountManager;
use Modules\Account\Jobs\Contact\UpdateInformation;
use Modules\Account\Requests\Contact\UpdateInformationRequest;
use Modules\System\Http\AdminController;

/**
 * Class ContactController
 * @package Modules\Account\Http\Admin
 */
class ContactController extends AdminController
{
    /**
     * @param AccountManager $manager
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
     * @return
     */
    public function index(AccountManager $manager)
    {
        $account = $manager->account();

        return $account->contactInformation->first();
    }

    /**
     * @param AccountContactInformation $accountContactInformation
     * @param UpdateInformationRequest $request
     * @param AccountManager $manager
     */
    public function update(AccountContactInformation $accountContactInformation, UpdateInformationRequest $request, AccountManager $manager)
    {
        $response = $this->dispatch(new UpdateInformation($accountContactInformation, translation_input($request)));

        $manager->updated();
    }
}
