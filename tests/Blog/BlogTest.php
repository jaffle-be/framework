<?php namespace Test\Blog;

use Test\Routes\RouteTests;
use Test\TestCase;

class BlogTest extends TestCase
{

    use RouteTests;

    public function testIndex()
    {
        //show method is tested in uri
        $this->tryRoute('store.blog.index');
    }
}