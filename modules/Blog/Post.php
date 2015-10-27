<?php namespace Modules\Blog;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\StoresMedia;
use Modules\Media\StoringMedia;
use Modules\Search\Model\Searchable;
use Modules\Search\Model\SearchableTrait;
use Modules\System\Presenter\PresentableEntity;
use Modules\System\Presenter\PresentableTrait;
use Modules\System\Scopes\FrontScoping;
use Modules\System\Scopes\ModelAccountResource;
use Modules\System\Seo\SeoEntity;
use Modules\System\Seo\SeoTrait;
use Modules\System\Translatable\Translatable;
use Modules\Tags\StoresTags;
use Modules\Tags\Taggable;
use Modules\Users\User;

class Post extends Model implements StoresMedia, Searchable, StoresTags, PresentableEntity, SeoEntity
{

    use PresentableTrait;
    use Translatable;
    use Taggable;
    use StoringMedia;
    use ModelAccountResource;
    use SearchableTrait;
    use SeoTrait;
    use FrontScoping;

    protected $table = 'posts';

    protected $media = '{account}/blog';

    protected $fillable = ['account_id', 'title', 'content', 'publish_at'];

    protected $translatedAttributes = ['title', 'content', 'publish_at'];

    protected $hidden = ['title', 'content', 'publish_at'];

    protected $presenter = 'Modules\Blog\Presenter\PostFrontPresenter';

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

    public function user()
    {
        return $this->belongsTo('Modules\Users\User');
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array $models
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new PostCollection($models);
    }

    public function scopeLatest(Builder $builder)
    {
        $builder->orderBy('post_translations.publish_at');
    }

    public function scopeAuthoredBy(Builder $builder, User $user)
    {
        $builder->where('user_id', $user->id);
    }

    public function scopeRelated(Builder $builder)
    {

    }

}