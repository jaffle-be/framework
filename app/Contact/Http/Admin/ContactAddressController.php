<?php

namespace App\Contact\Http\Admin;

use App\Contact\Address;
use App\Contact\Jobs\NewAddress;
use App\Contact\Jobs\UpdateAddress;
use App\Contact\Requests\NewAddressRequest;
use App\Contact\Requests\UpdateAddressRequest;
use App\System\Country\CountryRepository;
use App\System\Http\AdminController;

class ContactAddressController extends AdminController{

    public function widget(CountryRepository $countries)
    {
        $countries = $countries->select();

        return view('contact::admin.widgets.address', ['countries' => $countries]);
    }

    public function show(Address $address)
    {
        $address->load(['country' => function($query){
            $query->get(['id', 'iso_code_2']);
        }]);

        return $address;
    }

    public function store(NewAddressRequest $request)
    {
        $address = $this->dispatchFromArray(NewAddress::class, [
            'input' => $request->except('_token')
        ]);

        return $address;
    }

    public function update(Address $address, UpdateAddressRequest $request)
    {
        $address->load('country');

        if($this->dispatchFromArray(UpdateAddress::class, [
            'input' => $request->except(['_token', 'owner_id', 'owner_type']),
            'address' => $address,
        ]))
        {
            return $address;
        }
    }

}