<?php namespace Modules\Users;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{

    use \Modules\System\Translatable\Translatable;

    protected $table = 'user_skills';

    protected $fillable = ['name', 'description'];

    protected $translatedAttributes = ['name', 'description'];

    public function users()
    {
        return $this->belongsToMany('Modules\Users\User', 'user_skills_selection', 'user_id', 'skill_id');
    }

}