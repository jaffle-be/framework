<?php

namespace Modules\Account;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Scopes\ModelAccountResource;

/**
 * Class Role
 * @package Modules\Account
 */
class Role extends Model
{
    use ModelAccountResource;
    use \Modules\System\Translatable\Translatable;

    protected $table = 'account_membership_roles';

    protected $fillable = ['account_id', 'name'];

    protected $translatedAttributes = ['name'];
}
