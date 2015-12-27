<?php

namespace Test\Shop;

use Modules\Shop\Product\CategoryTranslation;
use Modules\Shop\Product\ProductTranslation;
use Test\FrontTestCase;
use Test\Routes\RouteTests;

class ShopTest extends FrontTestCase
{
    use RouteTests;

    public function testHome()
    {
        $this->tryRoute('store.shop.index');
    }

    public function testCategory()
    {
        $this->tryRoute('store.shop.category', [CategoryTranslation::first()]);
    }

    public function testProduct()
    {
        //        $this->tryRoute('store.shop.product', [ProductTranslation::where('locale', 'en')->where('published', true)->first()]);
    }

    public function testLogin()
    {
        $this->tryRoute('store.shop.login');
    }

    public function testRegister()
    {
        $this->tryRoute('store.shop.register');
    }

    public function testCheckout()
    {
        $this->tryRoute('store.shop.checkout.index');
    }
}
