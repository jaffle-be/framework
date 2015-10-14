<?php namespace App\System\Uri;

use App\System\Sluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class Uri extends Model
{
    protected $table = 'uris';

    protected $fillable = ['account_id', 'canonical_id', 'locale_id', 'uri', 'owner_type', 'owner_id'];

    protected $sluggable = [
        'build_from' => 'owner.title',
        'save_to'    => 'uri',
    ];

    public function owner()
    {
        return $this->morphTo();
    }

}