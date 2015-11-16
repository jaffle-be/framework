<?php namespace Modules\Tags;

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
//        'nl' => [
//            'type' => 'nested',
//            'properties' => [
//                'name' => [
//                    'type' => 'string'
//                ]
//            ]
//        ],
//        'en' => [
//            'type' => 'nested',
//            'properties' => [
//                'name' => [
//                    'type' => 'string'
//                ]
//            ]
//        ],
//        'fr' => [
//            'type' => 'nested',
//            'properties' => [
//                'name' => [
//                    'type' => 'string'
//                ]
//            ]
//        ],
//        'de' => [
//            'type' => 'nested',
//            'properties' => [
//                'name' => [
//                    'type' => 'string'
//                ]
//            ]
//        ]
    ];

}