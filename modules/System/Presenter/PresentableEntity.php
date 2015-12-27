<?php

namespace Modules\System\Presenter;

interface PresentableEntity
{

    /**
     * @return BasePresenter
     */
    public function present();
}
