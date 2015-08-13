<?php namespace App\Account;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{

    protected $table = "accounts";

    protected $fillable = ['alias', 'domain'];

    public function memberships()
    {
        return $this->hasMany('App\Account\Membership');
    }

    public function members()
    {
        return $this->belongsToMany('App\Users\User', 'account_memberships');
    }

    public function membershipInvitations()
    {
        return $this->hasMany('App\Account\MembershipInvitation');
    }

    public function contactInformation()
    {
        return $this->hasMany('App\Account\AccountContactInformation');
    }

    public function socialLinks()
    {
        return $this->morphOne('App\Contact\SocialLinks', 'owner');
    }

    public function getOwnerAttribute()
    {
        return $this->ownership->member;
    }

    public function ownership()
    {
        $relation = $this->hasOne('App\Account\Membership');

        $relation->where('is_owner', true);

        return $relation;
    }

    public function teams()
    {
        return $this->hasMany('App\Account\Team');
    }

    public function logo($size = null)
    {
        $logo = new AccountLogo([
            'id' => $this->getKey()
        ]);

        if (!$size) {
            $size = '40';
        }

        $logo = $logo->images;

        if ($logo) {
            return $logo->sizes()->dimension(null, $size)->first()->path;
        }
    }

}