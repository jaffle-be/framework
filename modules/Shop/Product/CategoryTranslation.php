<?php namespace Modules\Shop\Product;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Modules\System\Presenter\PresentableEntity;
use Modules\System\Presenter\PresentableTrait;
use Modules\System\Sluggable\Sluggable;
use Modules\System\Translatable\TranslationModel;

class CategoryTranslation extends TranslationModel implements PresentableEntity, SluggableInterface
{

    use Sluggable, PresentableTrait;

    protected $table = 'product_category_translations';

    protected $fillable = ['name'];

    protected $sluggable = [
        'build_from' => 'name',
    ];

    public function category()
    {
        return $this->belongsTo('Modules\Shop\Product\Category');
    }

}