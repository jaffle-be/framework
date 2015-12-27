<?php

namespace Modules\Users;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Account\MembershipOwner;
use Modules\Contact\AddressOwner;
use Modules\Contact\HasSocialLinks;
use Modules\Contact\OwnsAddress;
use Modules\Media\StoresMedia;
use Modules\Media\StoringMedia;
use Modules\Search\Model\Searchable;
use Modules\Search\Model\SearchableTrait;
use Modules\System\Translatable\Translatable;

class User extends Model implements Authenticatable, MembershipOwner, AddressOwner, StoresMedia, Searchable
{
    use OwnsAddress;
    use StoringMedia;
    use Translatable;
    use HasSocialLinks;
    use SearchableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    protected $media = '{account}/user';

    protected $translatedAttributes = ['bio', 'quote', 'quote_author'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'firstname', 'lastname', 'phone', 'vat', 'website', 'bio', 'quote', 'quote_author'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'reset_token_id', 'confirmation_token_id'];

    protected $cast = [
        'confirmed' => 'boolean',
    ];

    protected static $searchableMapping = [
        'id' => ['type' => 'integer'],
        'created_at' => [
            'type' => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss',
        ],
        'updated_at' => [
            'type' => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss',
        ],
    ];

    public function resetToken()
    {
        return $this->belongsTo('Modules\Users\Auth\Tokens\Token', 'reset_token_id');
    }

    public function confirmationToken()
    {
        return $this->belongsTo('Modules\Users\Auth\Tokens\Token', 'confirmation_token_id');
    }

    public function projects()
    {
        return $this->belongsToMany('Modules\Portfolio\Project', 'portfolio_project_collaborators', 'user_id', 'project_id');
    }

    public function skills()
    {
        return $this->belongsToMany('Modules\Users\Skill', 'user_skills_selection', 'user_id', 'skill_id')->withPivot(['level']);
    }

    public function posts()
    {
        return $this->hasMany('Modules\Blog\Post', 'user_id');
    }

    public function getNameAttribute()
    {
        $fullname = trim($this->firstname.' '.$this->lastname);

        return $fullname ?: 'John Doe';
    }

    public function getFunctionAttribute()
    {
        return isset($this->attributes['function']) ? $this->attributes['function'] : 'Happy teammember';
    }

    /**
     * Get the token value for the "remember me" session.
     *
     *
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * Set the token value for the "remember me" session.
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     *
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * Get the unique identifier for the user.
     *
     *
     */
    public function getAuthIdentifier()
    {
        return $this->id;
    }

    /**
     * Get the password for the user.
     *
     *
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getAuthIdentifierName()
    {
        return $this->getKeyName();
    }
}
