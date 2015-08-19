<?php namespace App\Search;

use Jaffle\Tools\Translatable;

class Config
{

    protected $index;

    protected $types;

    protected $invertedTypes;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function boot()
    {
        $this->index = $this->config['index'];

        $this->types = $this->config['types'];

        $this->invertedTypes = $this->invertTypes($this->config['types']);
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

    public function getWith($type)
    {
        $trait = Translatable::class;
        $class = $this->getClass($type);
        $stuff = class_uses($class);

        $with = isset($this->types[$type]['with']) ? $this->types[$type]['with'] : [];

        //if the type uses that translatable model, we will automatically handle those mappings
        if(in_array($trait, $stuff))
        {
            $object = new $class;

            $classname = $object->getTranslationModelName();

            $with = array_merge($with, ['translations' => [
                'class' => $classname,
                'key' => $object->translations()->getForeignKey(),
            ]]);

        }

        return $with;
    }

    public function getClass($type)
    {
        return $this->types[$type]['class'];
    }

    public function getInvertedTypes()
    {
        return $this->invertedTypes;
    }

    /**
     * This method will save an inverted array of relations.
     * We can then use it to trigger nested document changes.
     *
     * @param $types
     *
     * @return array
     */
    protected function invertTypes($types)
    {
        $inverted = [];

        foreach ($types as $type => $config) {
            foreach ($config['with'] as $relation => $class) {

                $key = $class['class'];

                if (!array_key_exists($key, $inverted)) {
                    $inverted[$key] = [];
                }

                $inverted[$key][] = [
                    'class'    => $config['class'],
                    'key'      => $class['key'],
                    'relation' => $relation
                ];
            }
        }

        return $inverted;
    }

}