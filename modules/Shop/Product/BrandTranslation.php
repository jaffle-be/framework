<?php namespace Modules\Shop\Product;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Modules\Search\Model\Searchable;
use Modules\Search\Model\SearchableTrait;
use Modules\System\Presenter\PresentableEntity;
use Modules\System\Presenter\PresentableTrait;
use Modules\System\Sluggable\Sluggable;
use Modules\System\Translatable\TranslationModel;

class BrandTranslation extends TranslationModel implements SluggableInterface, PresentableEntity, Searchable
{

    use Sluggable, PresentableTrait;
    use SearchableTrait;

    protected $table = 'product_brand_translations';

    protected $fillable = ['name', 'description'];

    protected $sluggable = [
        'build_from' => 'name',
    ];

    public function brand()
    {
        return $this->belongsTo('Modules\Shop\Product\Brand');
    }

}