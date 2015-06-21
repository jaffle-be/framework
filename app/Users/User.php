<?php namespace App\Users;

use App\Account\MembershipOwner;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable, MembershipOwner
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'reset_token_id', 'confirmation_token_id'];

    protected $cast = [
        'confirmed' => 'boolean'
    ];


    public function resetToken()
    {
        return $this->belongsTo('App\Users\Auth\Tokens\Token', 'reset_token_id');
    }

    public function confirmationToken()
    {
        return $this->belongsTo('App\Users\Auth\Tokens\Token', 'confirmation_token_id');
    }

    public function getNameAttribute()
    {
        return isset($this->attributes['name']) ? $this->attributes['name'] : 'Unknown';
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
