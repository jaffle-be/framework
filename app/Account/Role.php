<?php namespace App\Account;

use App\System\Scopes\ModelAccountResource;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    use ModelAccountResource;
    use Translatable;

    protected $table = 'account_membership_roles';

    protected $fillable = ['account_id', 'name'];

    protected $translatedAttributes = ['name'];

}