<?php

namespace Modules\Account;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Membership
 * @package Modules\Account
 */
class Membership extends Model
{
    protected $table = 'account_memberships';

    protected $fillable = ['is_owner'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo('Modules\Account\Account');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member()
    {
        return $this->belongsTo('Modules\Users\User', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('Modules\Account\Role');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany('Modules\Account\Team', 'account_team_memberships');
    }
}
