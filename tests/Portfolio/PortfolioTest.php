<?php namespace Test\Portfolio;

use Modules\Portfolio\ProjectTranslation;
use Test\Routes\RouteTests;
use Test\TestCase;

class PortfolioTest extends TestCase
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
