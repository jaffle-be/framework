<?php

namespace Modules\Users\Auth\Requests;

use App\Http\Requests\Request;

/**
 * Class SigninRequest
 * @package Modules\Users\Auth\Requests
 */
class SigninRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     *
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     *
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }
}
