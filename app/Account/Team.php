<?php namespace App\Account;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{

    use Translatable;

    protected $table = 'account_teams';

    protected $fillable = ['account_id', 'name'];

    protected $translatedAttributes = ['name'];

    public function memberships()
    {
        return $this->belongsToMany('App\Account\Membership', 'account_team_memberships', 'team_id', 'membership_id');
    }

    public function getCubeportfolioAttribute()
    {
        return 'cube' . str_slug(ucfirst($this->name));
    }

}