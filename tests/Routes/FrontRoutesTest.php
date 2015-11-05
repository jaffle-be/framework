<?php namespace Test\Routes;

use Test\TestCase;

class FrontRoutesTest extends TestCase
{

    use RouteTests;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testRoutes()
    {
        //we only test GET routes
        $this->tryRoute('store.home');
    }

}
