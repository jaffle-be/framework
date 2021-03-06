<?php

namespace Modules\Search;

use Elasticsearch\Client;
use Exception;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Events\Dispatcher;
use Modules\Search\Model\Searchable;
use Modules\System\MySoftDeletes;

/**
 * Class SearchService
 * @package Modules\Search
 */
class SearchService implements SearchServiceInterface
{
    use SearchResponder;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Config
     */
    protected $config;

    protected $service;

    /**
     * @var array
     */
    protected $listeners = [
        'created' => 'add',
        'updated' => 'update',
        'deleted' => 'delete',
    ];

    /**
     * @var array
     */
    protected $types = [];

    /**
     * @var array
     */
    protected $invertedTypes = [];

    /**
     * @param Container $container
     * @param Client $client
     * @param Config $config
     */
    public function __construct(Container $container, Client $client, Config $config)
    {
        $this->container = $container;

        $this->client = $client;

        $this->config = $config;

        $this->service = $this;
    }

    public function boot()
    {
        $this->config->boot();

        $this->autoIndex();
    }

    protected function autoIndex()
    {
        foreach ($this->config->getTypes() as $type) {
            $class = $this->config->getClass($type);

            $class = new $class();

            $class->setSearchableService($this);

            $this->regularAutoIndex($class, $this->config->getWith($type));
        }

        foreach ($this->config->getInvertedTypes() as $updated => $config) {
            $this->invertedAutoIndex($updated, $config);
        }
    }

    /**
     * This method will bind all events to the eloquent model created, updated or deleted events.
     * Note the events are not the creating, updating or deleting events, as these would possibly
     * index data that might change due to a model observer adjusting data.
     * @param Searchable $type
     * @param array $with
     */
    public function regularAutoIndex(Searchable $type, array $with)
    {
        /** @var Dispatcher $dispatcher */
        $dispatcher = $this->container->make('events');

        $me = $this;

        foreach ($this->listeners as $event => $listener) {
            $trigger = $type->getSearchableEventname($event);

            $type->setSearchableService($me);
            $type->setSearchableIndex($me->config->getIndex());

            if ($trigger) {
                $callback = function (Searchable $type) use ($me, $listener, $with) {
                    return $me->$listener($type);
                };

                $dispatcher->listen($trigger, $callback, 15);
            }
        }
    }

    /**
     * @param $updated
     * @param $inverted
     */
    protected function invertedAutoIndex($updated, $inverted)
    {
        foreach ($inverted as $invert) {
            $parent = new $invert['class']();

            $relation = $invert['relation'];

            $key = $invert['key'];

            $config = $this->getConfig($parent);

            $this->addInvertedListener($parent, $updated, $relation, $key, array_keys(array_get($config, 'with', [])));
        }
    }

    /**
     * @param Searchable $parent
     * @param $updated
     * @param $relation
     * @param $key
     * @param array $with
     */
    protected function addInvertedListener(Searchable $parent, $updated, $relation, $key, array $with)
    {
        $dispatcher = $this->container->make('events');

        $event = 'eloquent.saved: '.$updated;

        $dispatcher->listen($event, function ($model) use ($parent, $relation, $key, $with) {

            $result = $parent->with($with)->whereHas($relation, function ($query) use ($model, $key, $with) {
                $query->where($model->getKeyName(), '=', $model->getKey());
            });

            $documents = $result->get();

            foreach ($documents as $document) {
                $this->update($document);
            }
        });
    }

    /**
     * @param $parent
     * @return array
     */
    protected function getRelationsToLoad($parent)
    {
        $class = new $parent();

        return $this->config->getWith($class->getSearchableType());
    }

    /**
     * {@inheritdoc}
     */
    public function build($type)
    {
        $this->checkIndex();

        list($type, $relations) = $this->getSearchable($type);

        $me = $this;

        //for now we'll always disable scopes
        //we should probably keep it like this too
        //read up about routing in elasticsearch.
        //you could probably easily add the routing feature instead.
        $type->newQueryWithoutScopes()->chunk(250, function ($documents) use ($me, $relations, $type) {

            //make sure we disable global scopes on relations too
            foreach ($relations as $relation) {
                //does the related element use soft deletes?
                $related = $type->$relation()->getRelated();

                if (uses_trait($related, SoftDeletes::class)) {
                    $documents->load([
                        $relation => function ($query) {
                            $query->withTrashed();
                        },
                    ]);
                } else {
                    $documents->load($relation);
                }
            }

            foreach ($documents as $document) {
                $me->add($document, false);
            }
        });
    }

    public function flush()
    {
        $params = ['index' => $this->config->getIndex()];

        $this->client->indices()->delete($params);
    }

    /**
     * @param Searchable $type
     * @param bool|true $needsLoading
     */
    public function add(Searchable $type, $needsLoading = true)
    {
        //clone object so we do not touch original one.
        //this was messing with translatable library.
        //since the parent model saves before the translations,
        //translations wouldn't be in database and we overwrite them here by loading those translations
        $type = clone $type;
        /*
         * make sure the relations are initialised when creating a new object
         * else searching might fail since some relations expect to be an array and it would be indexed as null
         */
        if ($needsLoading) {
            $type->load(array_keys($this->config->getWith($type->getSearchableType())));
        }

        $data = $this->data($type);

        $this->client->index($data);
    }

    /**
     * @param Searchable $type
     */
    public function delete(Searchable $type)
    {
        if (uses_trait($type, MySoftDeletes::class)) {
            //only delete when fully being deleted.

            if ($type->beingFullyDeleted()) {
                $params = $this->data($type);

                $params = array_except($params, ['body']);

                $this->client->delete($params);
            }
            //maybe we should trigger an update here instead of doing nothing.
        } else {
            //Even regular soft deletes can be deleted.
            $params = $this->data($type);

            $params = array_except($params, ['body']);

            $this->client->delete($params);
        }
    }

    /**
     * @param Searchable $type
     */
    public function update(Searchable $type)
    {
        //clone object so we do not touch original one.
        //this was messing with translatable library.
        //since the parent model saves before the translations,
        //translations wouldn't be in database and we overwrite them here by loading those translations
        $type = clone $type;

        $params = $this->getBaseParams($type);

        $type->load(array_keys($this->config->getWith($type->getSearchableType())));

        $params = array_merge($params, [
            'id' => $type->getSearchableId(),
            'body' => [
                'doc' => $type->getSearchableDocument(),
            ],
        ]);

        if ($type->useSearchableRouting()) {
            $params['routing'] = $type->getSearchableRouting();
        }

        $this->client->update($params);
    }

    /**
     * Search the index.
     *
     * @param $type
     * @param array $params
     * @param array $with
     * @param int $paginated
     * @param \Closure $highlighter
     * @return array|\Illuminate\Pagination\LengthAwarePaginator
     */
    public function search($type, array $params, $with = [], $paginated = 15, \Closure $highlighter = null)
    {
        if (isset($params['body']['sort'])) {
            $params = $this->cleanSort($params);
        }

        if ($paginated) {
            $params['from'] = (app('request')->get('page', 1) - 1) * $paginated;
            $params['size'] = $paginated;
        }

        $result = $this->client->search($params);

        if ($highlighter) {
            //if we have a highlighter, we simply loop through the results and overwrite the original field.
            //this is dangerous though, a dev should not be using Elasticsearch results to manipulate data.
            //data should always be manipulated through your relational database.
            foreach ($result['hits']['hits'] as &$hit) {
                if (isset($hit['highlight'])) {
                    $hit['_source'] = $highlighter($hit['_source'], $hit['highlight']);
                }
            }
        }

        return $this->response($result, $with, $paginated, $this->container->make($this->config->getClass($type)));
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function aggregate(array $params)
    {
        $result = $this->client->search($params);

        //the resultset contains an array of aggregations.
        //if we only have one aggregation, we return an aggregation result,
        //if we have multiple, we'll return a collection of aggregation results.
        //but its always an array, so we can implement the same logic at first
        $aggregations = $result['aggregations'];

        return $aggregations;
    }

    /**
     * @return mixed
     */
    public function getPaginator()
    {
        return $this->container->make('Illuminate\Contracts\Pagination\Paginator');
    }

    /**
     * @param Searchable $type
     * @return mixed
     */
    public function getConfig(Searchable $type)
    {
        return $this->config->getType($type->getSearchableType());
    }

    /**
     * Update the settings for the elasticsearch instance.
     *
     * @param array $settings
     */
    public function updateSettings(array $settings)
    {
        $this->checkIndex();

        $indices = $this->client->indices();

        $toggle = ['index' => $this->config->getIndex()];

        $indices->close($toggle);

        $settings = [
            'index' => $this->config->getIndex(),
            'body' => $settings,
        ];

        $indices->putSettings($settings);

        $indices->open($toggle);

        foreach ($this->config->getTypes() as $type) {
            /* @var Searchable $object */
            $class = $this->config->getClass($type);
            $object = new $class();

            $indices->putMapping([
                'index' => $this->config->getIndex(),
                'type' => $type,
                'body' => [
                    'properties' => $object->getSearchableMapping($this->config->getWith($type)),
                ],
            ]);
        }

        $indices->refresh($toggle);
    }

    /**
     * Return the actual type.
     * People could have passed in a simple classname.
     *
     *
     * @param $type
     * @return array|mixed
     * @throws Exception
     */
    protected function getSearchable($type)
    {
        if (is_string($type)) {
            $classname = $this->config->getClass($type);

            $with = $this->config->getWith($type);

            $type = $this->container->make($classname);

            return [$type, array_keys($with)];
        }

        if (! is_object($type) || ! ($type instanceof Searchable)) {
            throw new Exception('Invalid searchable provided, expecting something Modules\Search\\Searchable');
        }

        return $type;
    }

    /**
     * @param Searchable $type
     * @return array
     */
    protected function getBaseParams(Searchable $type)
    {
        return [
            'index' => $this->config->getIndex(),
            'type' => $type->getSearchableType(),
        ];
    }

    protected function checkIndex()
    {
        $params = ['index' => $this->config->getIndex()];

        $indices = $this->client->indices();

        if (! $indices->exists($params)) {
            $indices->create($params);
            sleep(1);
        }
    }

    /**
     * @param Searchable $type
     * @return array
     */
    protected function data(Searchable $type)
    {
        $params = [
            'index' => $this->config->getIndex(),
            'type' => $type->getSearchableType(),
            'id' => $type->getSearchableId(),
            'body' => $type->getSearchableDocument(),
        ];

        if ($routing = $type->useSearchableRouting()) {
            $params['routing'] = $type->getSearchableRouting();
        }

        return $params;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param $params
     * @return mixed
     */
    protected function cleanSort($params)
    {
        //sorts best have a unmapped_type parameter, so queries won't fail for empty document sets.
        $sort = $params['body']['sort'];

        foreach ($sort as $key => $sorting) {
            //the initial value of sorting is always an array
            //either
            //['column_name' => 'sort_order']
            //or a complex one
            //['column_name' => [array]]

            $value_keys = array_keys($sorting);

            $column = array_pop($value_keys);

            if (is_array($sorting[$column])) {
                //the sorting is already set up as a object/array value (depends if you look at it from json or php)
                //so we only need to verify the existence of the unmapped_type parameter.
                if (! isset($sorting[$column]['unmapped_type'])) {
                    //lets take boolean, as its probably one of the fastest.
                    $sorting[$column]['unmapped_type'] = 'boolean';
                }
            } else {
                //the value represents the order in which to sort.
                $sorting[$column] = [
                    'order' => $sorting[$column],
                    'unmapped_type' => 'boolean',
                ];
            }

            //update the original array
            $sort[$key] = $sorting;
        }

        //put the local reference back into the complete array
        $params['body']['sort'] = $sort;

        //return the entire array as a result.
        return $params;
    }
}
