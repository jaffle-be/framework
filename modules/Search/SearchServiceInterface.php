<?php

namespace Modules\Search;

use Elasticsearch\Client;
use Modules\Search\Model\Searchable;

interface SearchServiceInterface
{
    /**
     * Register the regular listeners for the given type.
     *
     *
     */
    public function regularAutoIndex(Searchable $type, array $with);

    /**
     * Build the index for a type.
     *
     *
     */
    public function build($type);

    /**
     * Add to index.
     *
     *
     */
    public function add(Searchable $type, $needsLoading = true);

    /**
     * Delete from index.
     */
    public function delete(Searchable $type);

    /**
     * Update a document in the index.
     */
    public function update(Searchable $type);

    /**
     * Search the index.
     *
     *
     */
    public function search($type, array $params, $with = [], $paginated = 15, \Closure $highlighter = null);

    /**
     * Aggregate an index.
     *
     *
     */
    public function aggregate(array $params);

    /**
     *
     */
    public function getPaginator();

    /**
     * Return the config for the searchable type.
     *
     *
     */
    public function getConfig(Searchable $type);

    /**
     * Update the settings for the elasticsearch instance.
     *
     *
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
