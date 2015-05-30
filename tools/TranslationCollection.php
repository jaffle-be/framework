<?php namespace Jaffle\Tools;

use Illuminate\Database\Eloquent\Collection;

class TranslationCollection extends Collection
{
    public function toArray()
    {
        return with(new Collection($this->items))->keyBy('locale')->toArray();
    }
}