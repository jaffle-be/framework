<?php namespace App\System\Presenter;

use Exception;

trait PresentableTrait
{

    /**
     * @var BasePresenter
     */
    protected $presenterInstance;

    public function present()
    {
        if(!property_exists($this, 'presenter'))
        {
            throw new Exception('need the presenter property on ' . get_class($this));
        }

        if(!$this->presenterInstance)
        {
            $this->presenterInstance = new $this->presenter($this);
        }

        return $this->presenterInstance;
    }

}