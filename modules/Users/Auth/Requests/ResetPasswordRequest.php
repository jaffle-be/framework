<?php

namespace Modules\Users\Auth\Requests;

use App\Http\Requests\Request;

/**
 * Class ResetPasswordRequest
 * @package Modules\Users\Auth\Requests
 */
class ResetPasswordRequest extends Request
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required|min:8|confirmed',
        ];
    }
}
