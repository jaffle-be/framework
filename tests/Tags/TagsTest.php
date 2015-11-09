<?php namespace Test\Tags;

use Modules\Tags\Tag;
use Test\Routes\RouteTests;
use Test\TestCase;

class TagsTest extends TestCase
{

    use RouteTests;

    public function testShow()
    {
        $this->tryRoute('store.tags.show', [Tag::first()]);
    }
}