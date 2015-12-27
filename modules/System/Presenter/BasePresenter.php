<?php

namespace Modules\System\Presenter;

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

    public function getPresentableEntity()
    {
        return $this->entity;
    }

    /**
     *
     */
    public function __get($name)
    {
        if (method_exists($this, $name)) {
            return $this->$name();
        }

        return $this->entity->{$name};
    }
}
