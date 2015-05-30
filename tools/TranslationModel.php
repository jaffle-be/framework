<?php namespace Jaffle\Tools;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TranslationModel extends Model{

    public function newCollection(array $items = [])
    {
        return new TranslationCollection($items);
    }

}