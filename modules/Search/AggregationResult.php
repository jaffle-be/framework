<?php

namespace Modules\Search;

use Illuminate\Support\Collection;

class AggregationResult extends Collection
{
    protected $document_count;

    public function __construct($items = [], $document_count)
    {
        $this->document_count = $document_count;

        parent::__construct($items);
    }

    /**
     * Get the collection of items as a plain array.
     *
     * @return array
     */
    public function toArray()
    {
        $items = parent::toArray();

        return [
            'document_count' => $this->document_count,
            'buckets' => $items,
        ];
    }

    /**
     * Run a map over each of the items.
     *
     * @param  callable  $callback
     * @return static
     */
    public function map(callable $callback)
    {
        $keys = array_keys($this->items);

        $items = array_map($callback, $this->items, $keys);

        return new static(array_combine($keys, $items), $this->document_count);
    }
}
