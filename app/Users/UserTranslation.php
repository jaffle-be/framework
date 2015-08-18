<?php namespace App\Users;

use App\Search\Model\Searchable;
use App\Search\Model\SearchableTrait;
use Jaffle\Tools\TranslationModel;

class UserTranslation extends TranslationModel implements Searchable
{

    use SearchableTrait;

    protected $table = 'user_profile_translations';

    protected $fillable = ['bio', 'quote', 'quote_author'];

}