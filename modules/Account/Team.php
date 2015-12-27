<?php

namespace Modules\Account;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Scopes\ModelAccountResource;
use Modules\System\Translatable\Translatable;

/**
 * Class Team
 * @package Modules\Account
 */
class Team extends Model
{
    use ModelAccountResource;
    use Translatable;

    protected $table = 'account_teams';

    protected $fillable = ['account_id', 'name', 'description'];

    protected $translatedAttributes = ['name', 'description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function memberships()
    {
        return $this->belongsToMany('Modules\Account\Membership', 'account_team_memberships', 'team_id', 'membership_id');
    }

    /**
     * @return string
     */
    public function getCubeportfolioAttribute()
    {
        return 'cube'.str_slug(ucfirst($this->name));
    }
}
