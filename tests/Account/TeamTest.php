<?php namespace Test\Account;

use Test\Routes\RouteTests;
use Test\TestCase;

class TeamTest extends TestCase
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