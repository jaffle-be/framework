<?php namespace Test;

use App\Console\Kernel;

class TestCase extends \Illuminate\Foundation\Testing\TestCase
{

    protected $baseUrl = 'http://digiredo.local';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $this->stopMockingFront();
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    protected function startMockingFront()
    {
        putenv('RUNNING_TESTS_FRONT=true');
    }

    protected function stopMockingFront()
    {
        putenv('RUNNING_TESTS_FRONT=false');
    }
}