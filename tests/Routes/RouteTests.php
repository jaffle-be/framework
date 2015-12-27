<?php

namespace Test\Routes;

trait RouteTests
{
    protected function tryRoute($route, array $arguments = [])
    {
        $response = $this->call('GET', store_route($route, $arguments));

//        var_dump(strip_tags($response->getOriginalContent()));

        $this->assertEquals(200, $response->getStatusCode(), 'route failed: '.$route);
    }
}
