<?php namespace App\Media;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    use Translatable;

    protected $table = 'media_images';

    protected $fillable = ['path', 'filename', 'extension', 'width', 'height', 'title'];

    protected $translatedAttributes = ['title'];

    protected $hidden = ['filename', 'extension', 'width', 'height', 'owner_id', 'owner_type', 'created_at', 'updated_at', 'original_id'];

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

    public function scopeDimension($query, $width = null, $height = null, $boolean = 'and')
    {
        $clause = function ($query) use ($width, $height) {
            if ($width) {
                $query->where('width', $width);
            }

            if ($height) {
                $query->height('height', $height);
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