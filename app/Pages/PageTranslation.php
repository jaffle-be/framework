<?php namespace App\Pages;

use App\Search\Model\Searchable;
use App\Search\Model\SearchableTrait;
use App\System\Presenter\PresentableEntity;
use App\System\Presenter\PresentableTrait;
use App\System\Sluggable\OwnsSlug;
use App\System\Sluggable\SiteSluggable;
use App\System\Translatable\TranslationModel;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Illuminate\Http\Request;

class PageTranslation extends TranslationModel implements Searchable, SluggableInterface, OwnsSlug, PresentableEntity
{
    use SearchableTrait, SiteSluggable, PresentableTrait;

    protected $table = 'page_translations';

    protected $fillable = ['title', 'content', 'published'];

    protected $presenter = 'App\Pages\Presenter\PageFrontPresenter';

    protected $sluggable = [
        'build_from' => 'title',
    ];

    protected $touches = ['page'];

    protected $casts = [
        'published' => 'boolean'
    ];

    public function getAccount()
    {
        return $this->page->account;
    }

    public function page()
    {
        return $this->belongsTo('App\Pages\Page');
    }

    protected static $searchableMapping = [
        'created_at' => [
            'type'   => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss'
        ],
        'updated_at' => [
            'type'   => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss'
        ],
    ];

    public function toArray()
    {
        $data = parent::toArray();

        $request = app('request');

        if(starts_with($request->getRequestUri(), '/api'))
        {
            $data['extract'] = $this->present()->extract;
        }

        return $data;
    }

}