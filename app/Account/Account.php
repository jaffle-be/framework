<?php namespace App\Account;

use Illuminate\Database\Eloquent\Model;

class Account extends Model{

    protected $table = "accounts";

    protected $fillable = ['slug'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function memberships()
    {
        return $this->hasMany('App\Account\Membership');
    }

}