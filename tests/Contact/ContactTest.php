<?php

namespace Test\Contact;

use Test\FrontTestCase;
use Test\Routes\RouteTests;

class ContactTest extends FrontTestCase
{
    use RouteTests;

    public function testContact()
    {
        $this->tryRoute('store.contact.index');
    }
}
