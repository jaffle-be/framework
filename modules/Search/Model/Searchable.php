<?php

namespace Modules\Search\Model;

use Modules\Search\Query\Queryable;
use Modules\Search\SearchServiceInterface;

/**
 * Interface Searchable
 * @package Modules\Search\Model
 */
interface Searchable
{
    /**
     * Set the client for searching.
     *
     * @param SearchServiceInterface $service
     * @return
     */
    public function setSearchableService(SearchServiceInterface $service);

    /**
     * Get the client for searching.
     *
     *
     */
    public function getSearchableService();

    /**
     * Set the index for searching.
     * @param $index
     * @return
     */
    public function setSearchableIndex($index);

    /**
     * Get the index for searching.
     *
     *
     */
    public function getSearchableIndex();

    /**
     *
     */
    public function useSearchableRouting();

    /**
     * Get the routing for searching.
     *
     *
     */
    public function getSearchableRouting();

    /**
     * Returns a Queryable object for the type.
     *
     *
     */
    public function search();

    /**
     * Returns the type to use for indexing.
     *
     *
     */
    public function getSearchableType();

    /**
     * Return the document id to use for indexing.
     *
     *
     */
    public function getSearchableId();

    /**
     * Return the full document for indexing.
     *
     *
     */
    public function getSearchableDocument();

    /**
     * Get the corresponding model event to listen for when auto indexing.
     *
     * @param $event
     * @return
     */
    public function getSearchableEventname($event);

    /**
     * This is a 'hook' to a new model creation.
     * if it ever changes in eloquent, you only need to adjust this part.
     *
     * @param $data
     * @param array $with
     * @return
     */
    public function getSearchableNewModel($data, array $with);

    /**
     * Return the mappings to use to index our data.
     *
     * @param array $config
     * @return
     */
    public function getSearchableMapping(array $config);

    /**
     * Return the data for elastic suggestions
     * if $inheritFrom is passed, it will use that to name the suggest.
     *
     * @param Searchable $inheritFrom
     * @return
     */
    public function getSearchableSuggestData(Searchable $inheritFrom = null);
}
