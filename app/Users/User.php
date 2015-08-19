<?php namespace App\Users;

use App\Account\MembershipOwner;
use App\Contact\AddressOwner;
use App\Media\StoresMedia;
use App\Media\StoringMedia;
use App\Search\Model\Searchable;
use App\Search\Model\SearchableTrait;
use Jaffle\Tools\Translatable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable, MembershipOwner, AddressOwner, StoresMedia, Searchable
{

    use StoringMedia;
    use Translatable;
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
        'confirmed' => 'boolean'
    ];

    public function socialLinks()
    {
        return $this->morphOne('App\Contact\SocialLinks', 'owner');
    }

    public function address()
    {
        return $this->morphOne('App\Contact\Address', 'owner');
    }

    public function resetToken()
    {
        return $this->belongsTo('App\Users\Auth\Tokens\Token', 'reset_token_id');
    }

    public function confirmationToken()
    {
        return $this->belongsTo('App\Users\Auth\Tokens\Token', 'confirmation_token_id');
    }

    public function projects()
    {
        return $this->belongsToMany('App\Portfolio\Project', 'portfolio_project_collaborators', 'user_id', 'project_id');
    }

    public function skills()
    {
        return $this->belongsToMany('App\Users\Skill', 'user_skills_selection', 'user_id', 'skill_id')->withPivot(['level']);
    }

    public function getNameAttribute()
    {
        $fullname = trim($this->firstname . ' ' . $this->lastname);

        return $fullname ?: 'John Doe';
    }

    public function getFunctionAttribute()
    {
        return isset($this->attributes['function']) ? $this->attributes['function'] : 'Happy teammember';
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     *
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->id;
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

}
