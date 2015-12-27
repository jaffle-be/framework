<?php

namespace Test\Account;

use Test\FrontTestCase;
use Test\Routes\RouteTests;

class TeamTest extends FrontTestCase
{
    use RouteTests;

    public function testIndex()
    {
        $this->tryRoute('store.team.index');
    }

    public function testShow()
    {
        $member = $this->account()->members->first();

        $this->tryRoute('store.team.show', [$member]);
    }
}
