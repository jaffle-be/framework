<?php namespace Test\Portfolio;

use Modules\Portfolio\ProjectTranslation;
use Test\FrontTestCase;
use Test\Routes\RouteTests;

class PortfolioTest extends FrontTestCase
{

    use RouteTests;

    public function testIndex()
    {
        $this->tryRoute('store.portfolio.index');
    }

    public function testShow()
    {
        $project = ProjectTranslation::where('published', true)->where('locale', 'en')->first();
        $this->tryRoute('store.portfolio.show', [$project]);
    }

}
