<?php namespace Modules\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Modules\Search\Model\Searchable;
use Modules\Search\Model\SearchableTrait;
use Modules\System\Eventing\EventedRelations;
use Modules\System\Pushable\CanPush;
use Modules\System\Pushable\Pushable;
use Modules\System\Translatable\Translatable;
use Modules\System\Translatable\TranslationModel;

class Category extends Model implements Pushable, Searchable
{

    use Translatable;
    use EventedRelations;
    use CanPush;
    use SearchableTrait;

    protected $table = 'product_categories';

    protected $fillable = ['name', 'original_id'];

    protected $translatedAttributes = ['name'];

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

    public function selection()
    {
        return $this->hasOne('Modules\Shop\Gamma\CategorySelection');
    }

    public function products()
    {
        return $this->eventedBelongsToMany('Modules\Shop\Product\Product', 'product_categories_pivot', null, null, 'product_categories');
    }

    public function brands()
    {
        return $this->belongsToMany('Modules\Shop\Product\Brand', 'product_brands_pivot', null, null, 'brand_categories');
    }

    public function synonyms()
    {
        return $this->hasMany('Modules\Shop\Product\Category', 'original_id');
    }

    public function originalCategory()
    {
        return $this->belongsTo('Modules\Shop\Product\Category', 'original_id');
    }

    public function propertyGroups()
    {
        return $this->hasMany('Modules\Shop\Product\PropertyGroup', 'category_id');
    }

    protected function getSearchableSuggestPayload($translation)
    {
        //for a category, we use all synonyms as possible input
        //but always use the main category as output, together with those synonyms
        $category = $translation->category;

        if($category->original_id)
        {
            $category = $category->originalCategory;
        }

        $originalName = $category->translateOrNew($translation->locale)->name;

        $input = $originalName;
        $output = $originalName;
        $locale = $translation->locale;

        if($category->synonyms->count())
        {
            $translations = $category->synonyms->map(function($synonym) use ($locale){
                return $synonym->translate($locale);
            });

            $translations = $translations->filter(function($item){
                return $item instanceof TranslationModel && !empty($item->name);
            });

            $names = $translations->lists('name')->toArray();

            $input = array_merge([$originalName], $names);
            $output = $originalName . ', ' . implode(', ', $names);
        }

        $label = $output;

        return [
            'input'   => $input,
            'output'  => $output,
            'payload' => [
                'label' => $label,
                'value' => $category->id,
            ]
        ];
    }

}