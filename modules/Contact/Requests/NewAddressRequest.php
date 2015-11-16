<?php namespace Modules\Contact\Requests;

use App\Http\Requests\Request;

class NewAddressRequest extends Request
{

    public function rules()
    {
        return [
            'owner_id'   => 'required',
            'owner_type' => 'required',
            'street'     => 'required',
            'city'       => 'required',
            'postcode'   => 'required',
            'latitude'   => 'required',
            'longitude'  => 'required',
            'country'    => 'required',
        ];
    }

    public function authorize()
    {
        return true;
    }
}