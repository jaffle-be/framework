<?php

namespace Modules\System\Presenter;

/**
 * Interface EntityPresenter
 * @package Modules\System\Presenter
 */
interface EntityPresenter
{
    /**
     * @param PresentableEntity $entity
     * @return mixed
     */
    public function setPresentableEntity(PresentableEntity $entity);
}
