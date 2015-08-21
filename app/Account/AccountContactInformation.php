<?php

namespace App\Account;

use App\Contact\AddressOwner;
use App\Contact\OwnsAddress;
use Illuminate\Database\Eloquent\Model;

class AccountContactInformation extends Model implements AddressOwner{

    use OwnsAddress;

    protected $table = "account_contact_information";

    protected $fillable = ["email", "phone", "vat", "website", "hours"];

    public function account()
    {
        return $this->belongsTo('App\Account\Account');
    }

}