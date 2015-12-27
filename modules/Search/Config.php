<?php

namespace Modules\Search;

use Modules\System\Translatable\Translatable;

class Config
{
    protected $config;

    protected $index;

    protected $types = [];

    protected $inverted = [];

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
     * @return array
     * @internal param $types
     *
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

    public function getWith($type)
    {
        $with = isset($this->types[$type]['with']) ? $this->types[$type]['with'] : [];

        if ($this->usesTranslations($type)) {
            $instance = $this->getInstance($type);

            $with = array_merge($with, ['translations' => [
                'class' => $instance->getTranslationModelName(),
                'key' => $instance->translations()->getForeignKey(),
            ]]);
        }

        return $with;
    }

    /**
     *
     *
     * @return array
     */
    protected function usesTranslations($type)
    {
        return uses_trait($this->getClass($type), Translatable::class);
    }

    public function getClass($type)
    {
        return $this->types[$type]['class'];
    }

    /**
     *
     *
     * @return mixed
     */
    protected function getInstance($type)
    {
        $class = $this->getClass($type);

        $object = new $class();

        return $object;
    }

    /**
     *
     *
     *
     *
     * @return mixed
     * @internal param $inverted
     * @internal param $config
     * @internal param $class
     */
    protected function invert($nested, $parent, $key, $relation)
    {
        if (!array_key_exists($nested, $this->inverted)) {
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

    public function getTypes()
    {
        return array_keys($this->types);
    }

    public function getType($type)
    {
        return $this->types[$type];
    }

    public function getInvertedTypes()
    {
        return $this->inverted;
    }

    public function getSpeed()
    {
        return $this->config['refresh_interval'];
    }
}
