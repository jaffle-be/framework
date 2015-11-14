<?php namespace Test;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Console\Kernel;

class AdminTestCase extends \Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://digiredo.local';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        putenv('RUNNING_TESTS_FRONT=false');

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    protected function account()
    {
        return app('Modules\Account\AccountManager')->account();
    }

    protected function database(Model $model)
    {
        return $model->getConnection()->table($model->getTable());
    }

}
