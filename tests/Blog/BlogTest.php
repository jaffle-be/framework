<?php namespace Test\Blog;

use Modules\Account\Account;
use Modules\Blog\Post;
use Modules\Blog\PostTranslation;
use Modules\Users\User;
use Test\Routes\RouteTests;
use Test\TestCase;

class BlogTest extends TestCase
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