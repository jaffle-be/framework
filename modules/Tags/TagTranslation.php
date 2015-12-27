<?php

namespace Modules\Tags;

use Modules\Search\Model\Searchable;
use Modules\Search\Model\SearchableTrait;
use Modules\System\Translatable\TranslationModel;

class TagTranslation extends TranslationModel implements Searchable
{
    use SearchableTrait;

    protected $table = 'tag_translations';

    protected $fillable = ['name'];

    protected $hidden = ['created_at', 'updated_at', 'tag_id'];

    protected static $searchableMapping = [
        'id' => ['type' => 'integer'],
        'created_at' => [
            'type' => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss',
        ],
        'updated_at' => [
            'type' => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss',
        ],
    ];
}
