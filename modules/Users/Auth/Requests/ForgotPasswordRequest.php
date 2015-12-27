<?php

namespace Modules\Users\Auth\Requests;

use App\Http\Requests\Request;

/**
 * Class ForgotPasswordRequest
 * @package Modules\Users\Auth\Requests
 */
class ForgotPasswordRequest extends Request
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
        ];
    }
}
