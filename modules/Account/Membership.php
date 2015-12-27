<?php

namespace Modules\Account;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $table = 'account_memberships';

    protected $fillable = ['is_owner'];

    public function account()
    {
        return $this->belongsTo('Modules\Account\Account');
    }

    public function member()
    {
        return $this->belongsTo('Modules\Users\User', 'user_id');
    }

    public function role()
    {
        return $this->belongsTo('Modules\Account\Role');
    }

    public function teams()
    {
        return $this->belongsToMany('Modules\Account\Team', 'account_team_memberships');
    }
}
