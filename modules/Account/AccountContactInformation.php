<?php

namespace Modules\Account;

use Illuminate\Database\Eloquent\Model;
use Modules\Contact\AddressOwner;
use Modules\Contact\OwnsAddress;

class AccountContactInformation extends Model implements AddressOwner
{

    use OwnsAddress;

    protected $table = "account_contact_information";

    protected $fillable = ["email", "phone", "vat", "website", "hours"];

    public function account()
    {
        return $this->belongsTo('Modules\Account\Account');
    }

}