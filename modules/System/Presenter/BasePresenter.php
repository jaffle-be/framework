<?php

namespace Modules\System\Presenter;

/**
 * Class BasePresenter
 * @package Modules\System\Presenter
 */
abstract class BasePresenter implements EntityPresenter
{
    /**
     * @var PresentableEntity
     */
    protected $entity;

    /**
     * @param PresentableEntity $entity
     */
    public function setPresentableEntity(PresentableEntity $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return PresentableEntity
     */
    public function getPresentableEntity()
    {
        return $this->entity;
    }

    /**
     * @param $name
     * @return
     */
    public function __get($name)
    {
        if (method_exists($this, $name)) {
            return $this->$name();
        }

        return $this->entity->{$name};
    }
}
