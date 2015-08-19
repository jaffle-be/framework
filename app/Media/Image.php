<?php namespace App\Media;

use App\System\Scopes\ModelAccountResource;
use Jaffle\Tools\Translatable;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    use Translatable;
    use ModelAccountResource;

    protected $table = 'media_images';

    protected $fillable = ['account_id', 'path', 'filename', 'extension', 'width', 'height', 'title'];

    protected $translatedAttributes = ['title'];

    protected $hidden = ['account_id', 'filename', 'extension', 'width', 'height', 'owner_id', 'owner_type', 'created_at', 'updated_at', 'original_id'];

    public function account()
    {
        return $this->belongsTo('App\Account\Account');
    }

    public function original()
    {
        return $this->belongsTo('App\Media\Image', 'original_id');
    }

    public function sizes()
    {
        return $this->hasMany('App\Media\Image', 'original_id');
    }

    public function owner()
    {
        return $this->morphTo();
    }

    public function thumbnail($width = null, $height = null)
    {
        if (!$this->relationLoaded('sizes')) {

            $this->load(['sizes' => function($query) use ($width, $height){
                $query->dimension($width, $height);
            }]);

        }

        if ($image = $this->sizes->first()) {

            return $image->path;
        }
    }

    public function scopeDimension($query, $width = null, $height = null, $boolean = 'and')
    {
        $clause = function ($query) use ($width, $height) {
            if ($width) {
                $query->where('width', $width);
            }

            if ($height) {
                $query->where('height', $height);
            }
        };

        if ($boolean == 'and') {
            $query->where($clause);
        } else if ($boolean == 'or') {
            $query->orWhere($clause);
        }
    }

    public function scopeDimensions($query, array $sizes)
    {
        $query->where(function ($query) use ($sizes) {

            foreach ($sizes as $size) {

                $width = $size[0];

                $height = isset($size[1]) ? $size[1] : null;

                $query->dimension($query, $width, $height, 'or');
            }
        });
    }
}