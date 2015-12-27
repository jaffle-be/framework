<?php

namespace Modules\Module\Providers;

use Modules\System\ServiceProvider;

/**
 * Class ModuleServiceProvider
 * @package Modules\Module\Providers
 */
class ModuleServiceProvider extends ServiceProvider
{
    protected $namespace = 'module';

    public function register()
    {
    }

    protected function listeners()
    {
    }
}
