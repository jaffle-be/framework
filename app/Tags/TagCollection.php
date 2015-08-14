<?php namespace App\Tags;

use Illuminate\Database\Eloquent\Collection;

class TagCollection extends Collection
{

    /**
     * Format the collection for output
     *
     * @param string $format
     * @param string $glue
     *
     * @return array|string
     */
    public function format($format = '<a href=":url">:name</a>', $glue = ' / ')
    {
        $formats = [];

        $replace = [':name', ':url'];

        foreach ($this->items as $tag) {
            $by = [$tag->name, route('store.tags.show', [$tag])];

            $formattedTag = str_replace($replace, $by, $format);

            array_push($formats, $formattedTag);
        }

        $formats = implode($glue, $formats);

        return $formats;
    }

}