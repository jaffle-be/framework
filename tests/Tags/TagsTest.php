<?php namespace Test\Tags;

use Modules\Tags\Tag;
use Test\FrontTestCase;
use Test\Routes\RouteTests;
use Test\TestCase;

class TagsTest extends FrontTestCase
{

    use RouteTests;

    public function testShow()
    {
        $this->tryRoute('store.tags.show', [Tag::first()]);
    }
}