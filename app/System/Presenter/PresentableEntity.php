<?php namespace App\System\Presenter;

interface PresentableEntity
{

    /**
     * @return BasePresenter
     */
    public function present();
}