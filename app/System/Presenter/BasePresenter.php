<?php namespace App\System\Presenter;

abstract class BasePresenter implements EntityPresenter
{

    /**
     * @var PresentableEntity
     */
    protected $entity;

    public function setPresentableEntity(PresentableEntity $entity)
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