<?php namespace Test\Routes;

use Modules\Blog\PostTranslation;
use Modules\Pages\PageTranslation;
use Modules\Portfolio\ProjectTranslation;
use Test\TestCase;

class FrontRoutesTest extends TestCase
{

    use RouteTests;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testRoutes()
    {
        //we only test GET routes
        $this->tryRoute('store.home');
//        $this->tryRoute('store.auth.confirm-email.show');
        $this->tryRoute('store.auth.forgot-password.index');
//        $this->tryRoute('store.auth.reset-password.show');
        $this->tryRoute('store.auth.signin.index');

        $response = $this->call('GET', store_route('store.auth.signout.index'));
        $this->assertEquals(302, $response->getStatusCode());

        $this->tryRoute('store.auth.signup.index');
        $this->tryRoute('store.blog.index');
        $this->tryRoute('store.contact.index');
        $this->tryRoute('store.portfolio.index');

        $project = ProjectTranslation::where('published', true)->where('locale', 'en')->first();
        $this->tryRoute('store.portfolio.show', [$project]);
        $this->tryRoute('store.search.index');
        $this->tryRoute('store.shop.index');
        $this->tryRoute('store.shop.checkout.index');
        $this->tryRoute('store.shop.login');
        $this->tryRoute('store.shop.product');
        $this->tryRoute('store.shop.register');
        $this->tryRoute('store.shop.show');

        //this still fails due to hotfix not released yet.
//        $this->tryRoute('store.tags.show');
        $this->tryRoute('store.team.index');
        $member = $this->account()->members->first();
        $this->tryRoute('store.team.show', [$member]);

        $this->tryRoute('store.uri.show', [PageTranslation::where('locale', 'en')->where('published', true)->first()->uri]);
        $this->tryRoute('store.uri.show', [PostTranslation::where('locale', 'en')->where('publish_at', '<', 'now()')->first()->uri]);
    }

}
