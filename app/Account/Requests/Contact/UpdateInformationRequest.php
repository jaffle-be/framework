<?php namespace App\Account\Requests\Contact;

use App\Http\Requests\Request;

class UpdateInformationRequest extends Request
{

    public function rules()
    {
        return [
            'email' => 'email',
            'vat' => 'vat',
            'website' => 'url',
        ];
    }

    public function authorize()
    {
        return true;
    }

}