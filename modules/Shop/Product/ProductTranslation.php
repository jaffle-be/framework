<?php namespace Modules\Shop\Product;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Modules\System\Presenter\PresentableCache;
use Modules\System\Presenter\PresentableEntity;
use Modules\System\Presenter\PresentableTrait;
use Modules\System\Scopes\FrontScoping;
use Modules\System\Sluggable\Sluggable;
use Modules\System\Translatable\TranslationModel;

class ProductTranslation extends TranslationModel implements PresentableEntity, SluggableInterface, PresentableCache
{
    use Sluggable, PresentableTrait, FrontScoping;

    protected $table = 'product_translations';

    protected $fillable = ['name', 'title', 'content', 'published'];

    protected $presenter = 'Modules\Shop\Presenter\ProductFrontPresenter';

    protected $sluggable = [
        'build_from' => 'name',
    ];

    protected $casts = [
        'published' => 'boolean'
    ];

    public function product()
    {
        return $this->belongsTo('Modules\Shop\Product\Product');
    }

}