<?php

namespace Modules\Contact\Requests;

use App\Http\Requests\Request;

/**
 * Class UpdateAddressRequest
 * @package Modules\Contact\Requests
 */
class UpdateAddressRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
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
