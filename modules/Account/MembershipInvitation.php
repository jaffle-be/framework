<?php

namespace Modules\Account;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Scopes\ModelAccountResource;

/**
 * Class MembershipInvitation
 * @package Modules\Account
 */
class MembershipInvitation extends Model
{
    use ModelAccountResource;

    protected $table = 'account_membership_invitations';

    protected $fillable = ['email', 'token'];
}
