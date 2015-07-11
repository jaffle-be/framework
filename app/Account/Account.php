<?php namespace App\Account;

use Illuminate\Database\Eloquent\Model;

class Account extends Model{

    protected $table = "accounts";

    protected $fillable = ['alias', 'domain'];

    public function memberships()
    {
        return $this->hasMany('App\Account\Membership');
    }

    public function contactInformation()
    {
        return $this->hasMany('App\Account\AccountContactInformation');
    }

}