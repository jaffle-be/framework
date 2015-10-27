<?php namespace Test\Routes;

trait RouteTests
{

    protected function tryRoute($route, array $arguments = [])
    {
        $response = $this->call('GET', store_route($route, $arguments));

        $this->assertEquals(200, $response->getStatusCode(), 'route failed: ' . $route);
    }

}