<?php namespace App\Account;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model{

    protected $table = 'account_memberships';

    protected $fillable = ['is_owner'];

    public function account()
    {
        return $this->belongsTo('App\Account\Account');
    }

    public function member()
    {
        return $this->belongsTo('App\Users\User', 'user_id');
    }

    public function role()
    {
        return $this->belongsTo('App\Account\Role');
    }

    public function teams()
    {
        return $this->belongsToMany('App\Account\Team', 'account_team_memberships');
    }

}