<?php namespace Test\System\Uri;

use Modules\Blog\PostTranslation;
use Modules\Pages\PageTranslation;
use Test\Routes\RouteTests;
use Test\TestCase;

class UriTest extends TestCase
{

    use RouteTests;

    public function testUri()
    {
        $this->tryRoute('store.uri.show', [PageTranslation::where('locale', 'en')->where('published', true)->first()->uri]);
        $this->tryRoute('store.uri.show', [PostTranslation::where('locale', 'en')->where('publish_at', '<', 'now()')->first()->uri]);
    }

}