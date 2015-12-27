<?php

namespace Test\Search;

use Test\FrontTestCase;
use Test\Routes\RouteTests;

class SearchTest extends FrontTestCase
{
    use RouteTests;

    public function testSearch()
    {
        $this->tryRoute('store.search.index');
    }
}
