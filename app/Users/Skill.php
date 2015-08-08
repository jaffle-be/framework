<?php namespace App\Users;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use Translatable;

    protected $table = 'user_skills';

    protected $fillable = ['name', 'description'];

    protected $translatedAttributes = ['name', 'description'];

    public function users()
    {
        return $this->belongsToMany('App\Users\User', 'user_skills_selection', 'user_id', 'skill_id');
    }

}