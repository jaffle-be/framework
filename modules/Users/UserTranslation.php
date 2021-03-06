<?php

namespace Modules\Users;

use Modules\Search\Model\Searchable;
use Modules\Search\Model\SearchableTrait;
use Modules\System\Translatable\TranslationModel;

/**
 * Class UserTranslation
 * @package Modules\Users
 */
class UserTranslation extends TranslationModel implements Searchable
{
    use SearchableTrait;

    protected $table = 'user_profile_translations';

    protected $fillable = ['bio', 'quote', 'quote_author'];

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
