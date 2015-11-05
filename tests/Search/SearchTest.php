<?php namespace Test\Search;

use Test\Routes\RouteTests;
use Test\TestCase;

class SearchTest extends TestCase
{

    use RouteTests;

    public function testSearch()
    {
        $this->tryRoute('store.search.index');
    }
}