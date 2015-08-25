<?php namespace App\Account;

use App\Contact\HasSocialLinks;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasSocialLinks;

    protected $table = "accounts";

    protected $fillable = ['alias', 'domain'];

    public function locales()
    {
        return $this->belongsToMany('App\System\Locale', 'account_locales');
    }

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

    public function logo($width = null, $height = null)
    {
        $cached = $this->cachedLogo();

        if (empty($width) && empty($height)) {
            $height = '40';
        }

        if ($cached) {
            $image = $cached->sizes->filter(function ($image) use ($width, $height) {

                if (!empty($with)) {
                    return $image->width == $width;
                }

                if (!empty($height)) {
                    return $image->height == $height;
                }
            })->first();

            return $image->path;
        }
    }

    protected function cachedLogo()
    {
        return app('cache')->sear('account-logo', function () {

            $cached = new AccountLogo([
                'id' => $this->getKey()
            ]);

            if ($cached->images) {
                $cached->images;

                $cached->images->sizes;

                return $cached->images;
            }

            return false;
        });
    }

}