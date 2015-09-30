<?php namespace App\System\Presenter;

abstract class BasePresenter
{

    protected $entity;

    public function __construct(PresentableEntity $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param $name
     */
    public function __get($name)
    {
        if(method_exists($this, $name))
        {
            return $this->$name();
        }

        return $this->entity->{$name};
    }

}