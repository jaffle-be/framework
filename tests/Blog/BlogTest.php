<?php namespace Test\Blog;

use Modules\Account\Account;
use Modules\Users\User;
use Test\FrontTestCase;
use Test\Routes\RouteTests;

class BlogTest extends FrontTestCase
{
    use RouteTests;

    /**
     * @before
     */
    public function resources()
    {
        $user = factory(User::class)->create();
        $account = factory(Account::class)->create();
    }

    public function testIndex()
    {
        //show method is tested in uri
        $this->tryRoute('store.blog.index');
    }

    public function testWeCantAccessUnpublishedMaterial()
    {

    }
}