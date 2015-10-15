<?php namespace App\Pages;

use App\Media\StoresMedia;
use App\Media\StoringMedia;
use App\Search\Model\SearchableTrait;
use App\System\Presenter\PresentableTrait;
use App\System\Scopes\ModelAccountResource;
use App\System\Seo\SeoTrait;
use App\System\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Page extends Model implements StoresMedia
{
    use PresentableTrait;
    use Translatable;
    use StoringMedia;
    use ModelAccountResource;
    use SearchableTrait;
    use SeoTrait;

    protected $table = 'pages';

    protected $fillable = ['account_id', 'title', 'content', 'published'];

    protected $media = '{account}/pages';

    protected $translatedAttributes = ['title', 'content', 'published'];

    protected $hidden = ['title', 'content', 'published'];

    protected $presenter = 'App\Blog\Presenter\PostFrontPresenter';

    public function user()
    {
        return $this->belongsTo('App\Users\User');
    }

}