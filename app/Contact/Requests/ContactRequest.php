<?php

namespace App\Contact\Requests;

use App\Account\AccountManager;
use App\Http\Requests\Request;

class ContactRequest extends Request{

    public function rules()
    {
        return [
            'email' => 'required|email',
            'name' => 'required',
            'message' => 'required',
            'captcha' => 'required|captcha',
        ];
    }

    public function authorize(AccountManager $account)
    {
        $account = $account->account();

        $id = $this->request->get('_id');

        $true = $account->contactInformation->contains($id);

        return $true;
    }
}