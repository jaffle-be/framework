<?php namespace App\Account;

use Illuminate\Database\Eloquent\Model;

class MembershipInvitation extends Model
{

    protected $table = 'account_membership_invitations';

    protected $fillable = ['email', 'token'];

    public function account()
    {
        return $this->belongsTo('App\Account\Account');
    }

}