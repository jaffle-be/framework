<?php namespace App\Account;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model{

    protected $table = 'account_memberships';

    public function account()
    {
        return $this->belongsTo('App\Account\Account');
    }

    public function member()
    {
        return $this->belongsTo('App\Users\User', 'user_id');
    }

}