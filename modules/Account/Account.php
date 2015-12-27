<?php

namespace Modules\Account;

use Illuminate\Database\Eloquent\Model;
use Modules\Contact\HasSocialLinks;

/**
 * Class Account
 * @package Modules\Account
 */
class Account extends Model
{
    use HasSocialLinks;

    protected $table = 'accounts';

    protected $fillable = ['alias', 'domain'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function locales()
    {
        return $this->belongsToMany('Modules\System\Locale', 'account_locales');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function modules()
    {
        return $this->belongsToMany('Modules\Module\Module', 'account_modules', 'account_id', 'module_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function memberships()
    {
        return $this->hasMany('Modules\Account\Membership');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany('Modules\Users\User', 'account_memberships');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function membershipInvitations()
    {
        return $this->hasMany('Modules\Account\MembershipInvitation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contactInformation()
    {
        return $this->hasMany('Modules\Account\AccountContactInformation');
    }

    /**
     * @return mixed
     */
    public function getOwnerAttribute()
    {
        return $this->ownership->member;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function brandSelection()
    {
        return $this->hasMany('Modules\Shop\Gamma\BrandSelection');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categorySelection()
    {
        return $this->hasMany('Modules\Shop\Gamma\CategorySelection');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ownership()
    {
        $relation = $this->hasOne('Modules\Account\Membership');

        $relation->where('is_owner', true);

        return $relation;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teams()
    {
        return $this->hasMany('Modules\Account\Team');
    }

    /**
     * @param null $width
     * @param null $height
     * @return mixed
     */
    public function logo($width = null, $height = null)
    {
        $cached = $this->cachedLogo();

        if (empty($width) && empty($height)) {
            $height = '40';
        }

        if ($cached) {
            $image = $cached->sizes->filter(function ($image) use ($width, $height) {

                if (! empty($with)) {
                    return $image->width == $width;
                }

                if (! empty($height)) {
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
                'id' => $this->getKey(),
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
