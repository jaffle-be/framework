<?php namespace Modules\Account;

use Illuminate\Database\Eloquent\Model;
use Modules\Contact\HasSocialLinks;

class Account extends Model
{

    use HasSocialLinks;

    protected $table = "accounts";

    protected $fillable = ['alias', 'domain'];

    public function locales()
    {
        return $this->belongsToMany('Modules\System\Locale', 'account_locales');
    }

    public function modules()
    {
        return $this->belongsToMany('Modules\Module\Module', 'account_modules', 'account_id', 'module_id');
    }

    public function memberships()
    {
        return $this->hasMany('Modules\Account\Membership');
    }

    public function members()
    {
        return $this->belongsToMany('Modules\Users\User', 'account_memberships');
    }

    public function membershipInvitations()
    {
        return $this->hasMany('Modules\Account\MembershipInvitation');
    }

    public function contactInformation()
    {
        return $this->hasMany('Modules\Account\AccountContactInformation');
    }

    public function getOwnerAttribute()
    {
        return $this->ownership->member;
    }

    public function brandSelection()
    {
        return $this->hasMany('Modules\Shop\Gamma\BrandSelection');
    }

    public function categorySelection()
    {
        return $this->hasMany('Modules\Shop\Gamma\CategorySelection');
    }

    public function ownership()
    {
        $relation = $this->hasOne('Modules\Account\Membership');

        $relation->where('is_owner', true);

        return $relation;
    }

    public function teams()
    {
        return $this->hasMany('Modules\Account\Team');
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