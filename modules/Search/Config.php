<?php

namespace Modules\Search;

use Modules\System\Translatable\Translatable;

/**
 * Class Config
 * @package Modules\Search
 */
class Config
{
    protected $config;

    protected $index;

    protected $types = [];

    protected $inverted = [];

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function boot()
    {
        $this->index = $this->config['index'];

        $this->types = $this->config['types'];

        $this->invertTypes();
    }

    /**
     * This method will save an inverted array of relations.
     * We can then use it to trigger nested document changes.
     *
     *
     * $types
     */
    protected function invertTypes()
    {
        foreach ($this->types as $type => $config) {
            $parent = $config['class'];

            foreach ($this->getWith($type) as $relation => $nestedConfig) {
                $nested = $nestedConfig['class'];

                $key = $nestedConfig['key'];

                $this->invert($nested, $parent, $key, $relation);
            }
        }
    }

    /**
     * @param $type
     * @return array
     */
    public function getWith($type)
    {
        $with = isset($this->types[$type]['with']) ? $this->types[$type]['with'] : [];

        if ($this->usesTranslations($type)) {
            $instance = $this->getInstance($type);

            $with = array_merge($with, [
                'translations' => [
                    'class' => $instance->getTranslationModelName(),
                    'key' => $instance->translations()->getForeignKey(),
                ],
            ]);
        }

        return $with;
    }

    /**
     * @param $type
     * @return bool
     */
    protected function usesTranslations($type)
    {
        $class = $this->getClass($type);

        return uses_trait(new $class(), Translatable::class);
    }

    /**
     * @param $type
     * @return mixed
     */
    public function getClass($type)
    {
        return $this->types[$type]['class'];
    }

    /**
     * @param $type
     * @return
     */
    protected function getInstance($type)
    {
        $class = $this->getClass($type);

        $object = new $class();

        return $object;
    }

    /**
     *
     * $inverted
     * $config
     * $class
     * @param $nested
     * @param $parent
     * @param $key
     * @param $relation
     */
    protected function invert($nested, $parent, $key, $relation)
    {
        if (! array_key_exists($nested, $this->inverted)) {
            $this->inverted[$nested] = [];
        }

        $this->inverted[$nested][] = [
            'class' => $parent,
            'key' => $key,
            'relation' => $relation,
        ];
    }

    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @return array
     */
    public function getTypes()
    {
        return array_keys($this->types);
    }

    /**
     * @param $type
     * @return mixed
     */
    public function getType($type)
    {
        return $this->types[$type];
    }

    /**
     * @return array
     */
    public function getInvertedTypes()
    {
        return $this->inverted;
    }

    public function getSpeed()
    {
        return $this->config['refresh_interval'];
    }
}
