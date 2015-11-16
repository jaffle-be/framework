<?php

namespace Modules\Contact\Requests;

use App\Http\Requests\Request;

class UpdateAddressRequest extends Request
{

    public function rules()
    {
        return [
            'street'    => 'required',
            'city'      => 'required',
            'postcode'  => 'required',
            'latitude'  => 'required',
            'longitude' => 'required',
            'country'   => 'required',
        ];
    }

    public function authorize()
    {
        return true;
    }

}