<?php namespace Modules\Shop\Product;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Modules\Search\Model\Searchable;
use Modules\Search\Model\SearchableTrait;
use Modules\System\Presenter\PresentableEntity;
use Modules\System\Presenter\PresentableTrait;
use Modules\System\Sluggable\Sluggable;
use Modules\System\Translatable\TranslationModel;

class CategoryTranslation extends TranslationModel implements PresentableEntity, SluggableInterface, Searchable
{

    use Sluggable, PresentableTrait, SearchableTrait;

    protected $table = 'product_category_translations';

    protected $fillable = ['name'];

    protected $sluggable = [
        'build_from' => 'name',
    ];

    protected static $searchableMapping = [
        'id'         => ['type' => 'integer'],
        'created_at' => [
            'type'   => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss'
        ],
        'updated_at' => [
            'type'   => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss'
        ],
    ];

    public function category()
    {
        return $this->belongsTo('Modules\Shop\Product\Category');
    }

}