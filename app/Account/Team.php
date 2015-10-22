<?php namespace App\Account;

use App\System\Scopes\ModelAccountResource;
use App\System\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use ModelAccountResource;
    use Translatable;

    protected $table = 'account_teams';

    protected $fillable = ['account_id', 'name', 'description'];

    protected $translatedAttributes = ['name', 'description'];

    public function memberships()
    {
        return $this->belongsToMany('App\Account\Membership', 'account_team_memberships', 'team_id', 'membership_id');
    }

    public function getCubeportfolioAttribute()
    {
        return 'cube' . str_slug(ucfirst($this->name));
    }

}