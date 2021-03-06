<?php

namespace Modules\Search\Model;

use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\Search\SearchServiceInterface;
use Modules\System\Locale;
use Modules\System\Translatable\Translatable;

/**
 * Class SearchableTrait.
 */
trait SearchableTrait
{
    /**
     * @var SearchServiceInterface
     */
    protected static $searchableService;

    /**
     * @var string
     */
    protected static $searchableIndex;

    /**
     * @var
     */
    protected static $searchableRouting = false;

    /**
     * @param SearchServiceInterface $client
     */
    public function setSearchableService(SearchServiceInterface $client)
    {
        static::$searchableService = $client;
    }

    /**
     *
     */
    public function getSearchableService()
    {
        return static::$searchableService;
    }

    /**
     * @param $index
     */
    public function setSearchableIndex($index)
    {
        static::$searchableIndex = $index;
    }

    /**
     *
     */
    public function getSearchableIndex()
    {
        return static::$searchableIndex;
    }

    /**
     * @return mixed
     */
    public function useSearchableRouting()
    {
        return config('search.types.'.$this->getSearchableType().'.routing', false);
    }

    /**
     *
     */
    public function getSearchableRouting()
    {
        return $this->getAttribute($this->useSearchableRouting());
    }

    /**
     * Return the type this model uses in Elasticsearch.
     *
     *
     */
    public function getSearchableType()
    {
        return $this->getTable();
    }

    /**
     *
     */
    public function getSearchableId()
    {
        $key = $this->getKeyName();

        return $this->$key;
    }

    /**
     *
     */
    public function getSearchableDocument()
    {
        return array_merge($this->toArray(), $this->getSearchableSuggestData());
    }

    /**
     * @param $event
     * @return string
     */
    public function getSearchableEventname($event)
    {
        return "eloquent.{$event}: ".get_class($this);
    }

    /**
     *
     */
    public function search()
    {
        return $this->getSearchableService();
    }

    /**
     * {@inheritdoc}
     */
    public function getSearchableNewModel($data, array $with)
    {
        $base = array_except($data, array_keys($with));
        $base = $this->searchableShiftTranslations($base);

        $relations = array_only($data, array_keys($with));
        $relations = $this->searchableShiftTranslations($relations);

        unset($data);

        $this->unguard();
        $model = $this->newInstance();
        $model->fill($base);
        $this->reguard();

        //need to setup relations too :-)
        foreach ($with as $relation => $build) {
            $type = $this->getRelationType($relation, $model);

            if ($relation_data = $this->getSearchableNestedDocument($relations, $relation)) {
                if ($needsLoop = $this->relationNeedsLooping($type)) {
                    $relation_data = $this->getLoopedRelationData($build, $relation_data);
                } else {
                    $relation_data = $this->getSimpleRelationData($build, $relation_data);
                }

                $model->setRelation($relation, $relation_data);
            } else {
                if ($this->relationNeedsLooping($type)) {
                    $model->setRelation($relation, []);
                }
            }
        }

        return $model;
    }

    /**
     * @param $relations
     * @param $relation
     * @return mixed
     */
    protected function getSearchableNestedDocument($relations, $relation)
    {
        if (isset($relations[$relation]) && ! empty($relations[$relation])) {
            return $relations[$relation];
        }
    }

    /**
     * @param array $with
     * @return array
     * @throws \Exception
     */
    public function getSearchableMapping(array $with)
    {
        $mapping = [];

        //the mapping we want to use should also include the mappings for the nested documents.
        if (property_exists(__CLASS__, 'searchableMapping')) {
            $mapping = static::$searchableMapping;
        }

        if (uses_trait($this, Translatable::class)) {
            $suggests = [];

            foreach (Locale::all() as $locale) {
                $suggests[$this->getSearchableSuggestName($locale)] = [
                    'type' => 'completion',
                    'analyzer' => 'simple',
                    'search_analyzer' => 'simple',
                    'payloads' => true,
                ];
            }

            $mapping = array_merge($mapping, $suggests);
        }

        foreach ($with as $type => $config) {
            $related = new $config['class']();

            if ($type == 'translations') {
                if (! $related instanceof Searchable) {
                    throw new \Exception(sprintf('Translation model %s needs to be searchable', get_class($related)));
                }

                $locale_map = $related->getSearchableMapping([]);

                foreach (config('system.locales') as $locale) {
                    $nested_map[$locale] = [
                        'type' => 'nested',
                        'properties' => $locale_map,
                    ];
                }
            } elseif ($related instanceof Searchable) {
                $nested_map = $related->getSearchableMapping([]);
            }

            $mapping[$type] = [
                'type' => 'nested',
                'properties' => isset($nested_map) ? $nested_map : [],
            ];
        }

        return $mapping;
    }

    /**
     * @param $relation
     * @param $model
     * @return string
     */
    protected function getRelationType($relation, $model)
    {
        /** @var Relation $foreign */
        $foreign = $model->$relation();

        $type = get_class($foreign);

        return $type;
    }

    /**
     * @param $type
     * @return bool
     */
    protected function relationNeedsLooping($type)
    {
        $needsLoop = ['HasMany', 'BelongsToMany', 'MorphToMany'];

        foreach ($needsLoop as $loop) {
            if (ends_with($type, $loop)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $build
     * @param $relation_data
     * @return
     */
    protected function getLoopedRelationData($build, $relation_data)
    {
        $class = $build['class'];

        $class = new $class();

        $collection = $class->newCollection();

        foreach ($relation_data as $data) {
            $collection->push($this->getSimpleRelationData($build, $data));
        }

        return $collection;
    }

    /**
     * @param $build
     * @param $relation_data
     * @return
     */
    protected function getSimpleRelationData($build, $relation_data)
    {
        $class = $build['class'];

        $class = new $class();

        $class->unguard();

        $instance = $class->newInstance();

        $instance->fill($relation_data);

        $class->reguard();

        return $instance;
    }

    /**
     * @param array $data
     * @return array
     */
    protected function searchableShiftTranslations(array $data)
    {
        foreach ($data as $key => &$value) {
            if (is_array($value)) {
                $value = $this->searchableShiftTranslations($value);
            }
        }

        if (isset($data['translations'])) {
            $data = array_merge($data, $data['translations']);
            unset($data['translations']);
        }

        return $data;
    }

    /**
     * keep this public, this allows for easy searching inheriting.
     *
     * @param Searchable $inheritFrom
     * @return array
     */
    public function getSearchableSuggestData(Searchable $inheritFrom = null)
    {
        $data = [];

        if (uses_trait($this, Translatable::class)) {
            //foreach locale we add a different suggest
            foreach (Locale::all() as $locale) {
                $translation = $this->translate($locale->slug);

                if (! $translation) {
                    continue;
                }

                $data[$this->getSearchableSuggestName($locale, $inheritFrom)] = $this->getSearchableSuggestPayload($translation);
            }
        }

        return $data;
    }

    /**
     * @param $locale
     * @param Searchable $inheritFrom
     * @return string
     */
    protected function getSearchableSuggestName($locale, Searchable $inheritFrom = null)
    {
        $suffix = '_suggest_'.$locale->slug;

        if ($inheritFrom) {
            return $inheritFrom->getSearchableType().$suffix;
        }

        return $this->getSearchableType().$suffix;
    }

    /**
     * @param $translation
     * @return array
     */
    protected function getSearchableSuggestPayload($translation)
    {
        return [
            'input' => $translation->name,
            'output' => $translation->name,
            'payload' => [
                'label' => $translation->name,
                'value' => $this->id,
            ],
        ];
    }
}
