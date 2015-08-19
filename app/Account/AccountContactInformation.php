<?php

namespace App\Account;

use App\Contact\AddressOwner;
use Jaffle\Tools\Translatable;
use Illuminate\Database\Eloquent\Model;

class AccountContactInformation extends Model implements AddressOwner{

    protected $table = "account_contact_information";

    protected $fillable = ["email", "phone", "vat", "website", "hours"];

    public function account()
    {
        return $this->belongsTo('App\Account\Account');
    }

    public function address()
    {
        return $this->morphOne('App\Contact\Address', 'owner');
    }

}