<?php namespace Modules\Menu\Facade;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Illuminate\Log\Writer
 */
class Menu extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'menu'; }

}
