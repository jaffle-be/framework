<?php namespace App\Blog;

use App\Search\Model\Searchable;
use App\Search\Model\SearchableTrait;
use App\System\Translatable\TranslationModel;
use Carbon\Carbon;

class PostTranslation extends TranslationModel implements Searchable
{

    use SearchableTrait;

    protected $table = 'post_translations';

    protected $fillable = ['title', 'extract', 'content', 'publish_at'];

    protected $dates = ['publish_at'];

    protected static $searchableMapping = [
//        'publish_at' => [
//            'type'   => 'date',
//            'format' => 'yyyy-MM-dd HH:mm:ss'
//        ],
        'created_at' => [
            'type'   => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss'
        ],
        'updated_at' => [
            'type'   => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss'
        ],
    ];

    public function setPublishAtAttribute($value)
    {
        if($value)
        {
            $this->attributes['publish_at'] = Carbon::createFromFormat('d/m/Y', $value);
        }
    }

    public function toArray()
    {
        $data = parent::toArray();

        if($data['publish_at'])
        {
            $data['publish_at'] = $this->publish_at->format('d/m/Y');
        }

        return $data;
    }

    public function user()
    {
        return $this->belongsTo('App\Users\User');
    }

    public function scopeLastPublished($query, $locale = null)
    {
        if (empty($locale)) {
            $locale = app()->getLocale();
        }

        $query->where('locale', $locale)->orderBy('publish_at');
    }
}