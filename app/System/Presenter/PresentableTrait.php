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
            try{

                $presenter = app($this->presenter);

                $presenter->setPresentableEntity($this);

                $this->presenterInstance = $presenter;
            }
            catch(\Exception $e)
            {
                throw new \Exception('There is a problem building your entity presenter: ' . $this->presenter);
            }

        }

        return $this->presenterInstance;
    }

}