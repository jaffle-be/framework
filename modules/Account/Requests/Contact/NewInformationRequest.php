<?php

namespace Modules\Account\Requests\Contact;

use App\Http\Requests\Request;

/**
 * Class NewInformationRequest
 * @package Modules\Account\Requests\Contact
 */
class NewInformationRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'email',
            'vat' => 'vat',
            'website' => 'url',
        ];
    }

    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
