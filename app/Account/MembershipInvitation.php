<?php namespace App\Account;

use App\System\Scopes\ModelAccountResource;
use Illuminate\Database\Eloquent\Model;

class MembershipInvitation extends Model
{
    use ModelAccountResource;

    protected $table = 'account_membership_invitations';

    protected $fillable = ['email', 'token'];

    public function account()
    {
        return $this->belongsTo('App\Account\Account');
    }

}