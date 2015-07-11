<?php

namespace App\Account;

use App\Contact\AddressOwner;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class AccountContactInformation extends Model implements AddressOwner{

    use Translatable;

    protected $table = "account_contact_information";

    protected $fillable = ["contact_address_id", "description", "widget"];

    protected $translatedAttributes = [ 'description', 'widget' ];

    public function account()
    {
        return $this->belongsTo('App\Account');
    }

    public function address()
    {
        return $this->morphOne('App\Contact\Address', 'owner');
    }

}