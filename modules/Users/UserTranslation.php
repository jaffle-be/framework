<?php namespace Modules\Users;

use Modules\Search\Model\Searchable;
use Modules\Search\Model\SearchableTrait;
use Modules\System\Translatable\TranslationModel;

class UserTranslation extends TranslationModel implements Searchable
{

    use SearchableTrait;

    protected $table = 'user_profile_translations';

    protected $fillable = ['bio', 'quote', 'quote_author'];

}