<?php namespace Test;

class TestCase extends \Illuminate\Foundation\Testing\TestCase
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

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
    }

    protected function account()
    {
        return app('Modules\Account\AccountManager')->account();
    }

}
