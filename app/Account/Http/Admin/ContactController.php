<?php

namespace App\Account\Http\Admin;

use App\Account\AccountManager;
use App\Http\Controllers\Controller;

class ContactController extends Controller{

    public function page(AccountManager $manager)
    {
        $account = $manager->account();

        $account->load(['contactInformation', 'contactInformation.address']);

        $contact = $account->contactInformation->first();

        $address = $contact ? $contact->address : null;

        return view('account::contact.settings', ['account' => $account, 'contact' => $contact, 'address' => $address]);
    }

}