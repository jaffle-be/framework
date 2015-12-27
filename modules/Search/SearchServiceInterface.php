<?php

namespace Modules\Search;

use Modules\Search\Model\Searchable;

/**
 * Interface SearchServiceInterface
 * @package Modules\Search
 */
interface SearchServiceInterface
{
    /**
     * Register the regular listeners for the given type.
     *
     * @param Searchable $type
     * @param array $with
     * @return
     */
    public function regularAutoIndex(Searchable $type, array $with);

    /**
     * Build the index for a type.
     *
     * @param $type
     * @return
     */
    public function build($type);

    /**
     * Add to index.
     *
     * @param Searchable $type
     * @param bool $needsLoading
     * @return
     */
    public function add(Searchable $type, $needsLoading = true);

    /**
     * Delete from index.
     * @param Searchable $type
     * @return
     */
    public function delete(Searchable $type);

    /**
     * Update a document in the index.
     * @param Searchable $type
     * @return
     */
    public function update(Searchable $type);

    /**
     * Search the index.
     *
     * @param $type
     * @param array $params
     * @param array $with
     * @param int $paginated
     * @param \Closure $highlighter
     * @return
     */
    public function search($type, array $params, $with = [], $paginated = 15, \Closure $highlighter = null);

    /**
     * Aggregate an index.
     *
     * @param array $params
     * @return
     */
    public function aggregate(array $params);

    /**
     *
     */
    public function getPaginator();

    /**
     * Return the config for the searchable type.
     *
     * @param Searchable $type
     * @return
     */
    public function getConfig(Searchable $type);

    /**
     * Update the settings for the elasticsearch instance.
     *
     * @param array $settings
     * @return
     */
    public function updateSettings(array $settings);

    /**
     * Boot the search service.
     * This method should parse the configurations and set the auto indexing.
     *
     *
     */
    public function boot();

    /**
     *
     */
    public function getClient();
}
