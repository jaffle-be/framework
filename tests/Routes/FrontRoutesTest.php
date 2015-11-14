<?php namespace Test\Routes;

use Test\FrontTestCase;

class FrontRoutesFrontTest extends FrontTestCase
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
