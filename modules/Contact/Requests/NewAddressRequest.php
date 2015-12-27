<?php

namespace Modules\Contact\Requests;

use App\Http\Requests\Request;

/**
 * Class NewAddressRequest
 * @package Modules\Contact\Requests
 */
class NewAddressRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'owner_id' => 'required',
            'owner_type' => 'required',
            'street' => 'required',
            'city' => 'required',
            'postcode' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'country' => 'required',
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
