<?php namespace App\Pages;

use App\Media\StoresMedia;
use App\Media\StoringMedia;
use App\Menu\MenuHookable;
use App\Search\Model\SearchableTrait;
use App\System\Presenter\PresentableEntity;
use App\System\Presenter\PresentableTrait;
use App\System\Scopes\ModelAccountResource;
use App\System\Scopes\ModelAutoSort;
use App\System\Seo\SeoEntity;
use App\System\Seo\SeoTrait;
use App\System\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class Page extends Model implements StoresMedia, SeoEntity, PresentableEntity, MenuHookable
{

    use PresentableTrait;
    use Translatable;
    use StoringMedia;
    use ModelAccountResource;
    use SearchableTrait;
    use SeoTrait;
    use ModelAutoSort;

    protected $table = 'pages';

    protected $fillable = ['account_id', 'title', 'content', 'published'];

    protected $media = '{account}/pages';

    protected $translatedAttributes = ['title', 'content', 'published'];

    protected $hidden = ['title', 'content', 'published'];

    protected $presenter = 'App\Pages\Presenter\PageFrontPresenter';

    public function user()
    {
        return $this->belongsTo('App\Users\User');
    }

    public function parent()
    {
        return $this->belongsTo('App\Pages\Page', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Pages\Page', 'parent_id');
    }

    public function scopeMainPages(Builder $builder){
        $builder->whereNull('parent_id');
    }

    public function scopeBut(Builder $builder, Collection $pages)
    {
        if($pages->count() > 0)
        {
            $builder->whereNotIn($this->getKeyName(), $pages->lists($this->getKeyName())->toArray());
        }
    }

    public function scopeOrphans(Builder $builder)
    {
        $builder->whereNull('parent_id');
    }

    /**
     * @return array
     */
    public function getMenuLocalisedNames()
    {
        $translations = $this->translations->toArray();

        return array_map(function($item){
            return $item['title'];
        }, $translations);
    }

}