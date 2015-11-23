<?php namespace Test;

use Illuminate\Foundation\Console\Kernel;

class FrontTestCase extends \Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://digiredo.local';

    public function setUp()
    {
        putenv('RUNNING_TESTS_FRONT=true');

        parent::setUp();
    }

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        putenv('RUNNING_TESTS_FRONT=true');

        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    protected function account()
    {
        return app('Modules\Account\AccountManager')->account();
    }

}
