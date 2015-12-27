<?php

namespace Modules\Contact\Requests;

use App\Http\Requests\Request;
use Modules\Account\AccountManager;

/**
 * Class ContactRequest
 * @package Modules\Contact\Requests
 */
class ContactRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'name' => 'required',
            'message' => 'required',
            'captcha' => 'required|captcha',
        ];
    }

    /**
     * @param AccountManager $account
     * @return mixed
     */
    public function authorize(AccountManager $account)
    {
        $account = $account->account();

        $id = $this->request->get('_id');

        $true = $account->contactInformation->contains($id);

        return $true;
    }
}
