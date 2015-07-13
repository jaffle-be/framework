<?php

namespace App\Account;

use App\Contact\AddressOwner;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class AccountContactInformation extends Model implements AddressOwner{

    use Translatable;

    protected $table = "account_contact_information";

    protected $fillable = ["email", "phone", "vat", "website", "hours", "form_description", "widget_title", "widget_content"];

    protected $translatedAttributes = [ 'form_description', 'widget_title', 'widget_content' ];

    public function account()
    {
        return $this->belongsTo('App\Account\Account');
    }

    public function address()
    {
        return $this->morphOne('App\Contact\Address', 'owner');
    }

}