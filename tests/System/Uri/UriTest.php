<?php

namespace Test\System\Uri;

use Modules\Blog\PostTranslation;
use Modules\Pages\PageTranslation;
use Test\FrontTestCase;
use Test\Routes\RouteTests;

class UriTest extends FrontTestCase
{
    use RouteTests;

    public function testUriFrontRoutes()
    {
        $this->tryRoute('store.uri.show', [PageTranslation::where('locale', 'en')->where('published', true)->first()->uri]);
        $this->tryRoute('store.uri.show', [PostTranslation::where('locale', 'en')->where('publish_at', '<', 'now()')->first()->uri]);
    }
}
