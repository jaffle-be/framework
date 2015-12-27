<?php

namespace Modules\Contact\Http\Admin;

use Modules\Contact\Address;
use Modules\Contact\Jobs\NewAddress;
use Modules\Contact\Jobs\UpdateAddress;
use Modules\Contact\Requests\NewAddressRequest;
use Modules\Contact\Requests\UpdateAddressRequest;
use Modules\System\Country\CountryRepository;
use Modules\System\Http\AdminController;

class ContactAddressController extends AdminController
{

    public function widget(CountryRepository $countries)
    {
        $countries = $countries->select();

        return view('contact::admin.widgets.address', ['countries' => $countries]);
    }

    public function show(Address $address)
    {
        $address->load(['country' => function ($query) {
            $query->get(['id', 'iso_code_2']);
        }]);

        return $address;
    }

    public function store(NewAddressRequest $request)
    {
        $address = $this->dispatch(new NewAddress($request->except('_token')));

        return $address;
    }

    public function update(Address $address, UpdateAddressRequest $request)
    {
        $address->load('country');

        if ($this->dispatch(new UpdateAddress($address, $request->except(['_token', 'owner_id', 'owner_type'])))
        ) {
            return $address;
        }
    }

}