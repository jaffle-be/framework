<?php namespace Modules\Users\Auth\Requests;

use App\Http\Requests\Request;

class ResetPasswordRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'    => 'required',
            'password' => 'required|min:8|confirmed',
        ];
    }

}