<?php

namespace Modules\System\Presenter;

use Exception;

/**
 * Class PresentableTrait
 * @package Modules\System\Presenter
 */
trait PresentableTrait
{
    /**
     * @var BasePresenter
     */
    protected $presenterInstance;

    /**
     * @return \Illuminate\Foundation\Application|mixed|BasePresenter
     * @throws Exception
     */
    public function present()
    {
        if (! property_exists($this, 'presenter')) {
            throw new Exception('need the presenter property on '.get_class($this));
        }

        if (! $this->presenterInstance) {
            try {
                $presenter = app($this->presenter);

                $presenter->setPresentableEntity($this);

                $this->presenterInstance = $presenter;
            } catch (\Exception $e) {
                throw new \Exception('There is a problem building your entity presenter: '.$this->presenter."\nMessage: ".$e->getMessage());
            }
        }

        return $this->presenterInstance;
    }
}
