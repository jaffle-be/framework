<?php

namespace Modules\Search;

use Elasticsearch\Client;
use Modules\Search\Model\Searchable;

interface SearchServiceInterface
{
    /**
     * Register the regular listeners for the given type.
     *
     * @return
     */
    public function regularAutoIndex(Searchable $type, array $with);

    /**
     * Build the index for a type.
     *
     * @return
     */
    public function build($type);

    /**
     * Add to index.
     *
     * @return
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
     * @return mixed
     */
    public function search($type, array $params, $with = [], $paginated = 15, \Closure $highlighter = null);

    /**
     * Aggregate an index.
     *
     * @return mixed
     */
    public function aggregate(array $params);

    /**
     * @return \Illuminate\Pagination\Factory
     */
    public function getPaginator();

    /**
     * Return the config for the searchable type.
     *
     * @return mixed
     */
    public function getConfig(Searchable $type);

    /**
     * Update the settings for the elasticsearch instance.
     *
     * @return bool
     */
    public function updateSettings(array $settings);

    /**
     * Boot the search service.
     * This method should parse the configurations and set the auto indexing.
     *
     * @return mixed
     */
    public function boot();

    /**
     * @return Client
     */
    public function getClient();
}
