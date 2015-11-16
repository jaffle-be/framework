<?php namespace Modules\Pages;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Modules\Media\StoresMedia;
use Modules\Media\StoringMedia;
use Modules\Menu\MenuHookable;
use Modules\Search\Model\SearchableTrait;
use Modules\System\Presenter\PresentableEntity;
use Modules\System\Presenter\PresentableTrait;
use Modules\System\Scopes\ModelAccountResource;
use Modules\System\Scopes\ModelAutoSort;
use Modules\System\Seo\SeoEntity;
use Modules\System\Seo\SeoTrait;
use Modules\System\Translatable\Translatable;

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

    protected $presenter = 'Modules\Pages\Presenter\PageFrontPresenter';

    public function user()
    {
        return $this->belongsTo('Modules\Users\User');
    }

    public function parent()
    {
        return $this->belongsTo('Modules\Pages\Page', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('Modules\Pages\Page', 'parent_id');
    }

    public function scopeMainPages(Builder $builder)
    {
        $builder->whereNull('parent_id');
    }

    public function scopeBut(Builder $builder, Collection $pages)
    {
        if ($pages->count() > 0) {
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

        return array_map(function ($item) {
            return $item['title'];
        }, $translations);
    }

}