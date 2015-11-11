<?php namespace Test\Contact;

use Test\Routes\RouteTests;
use Test\TestCase;

class ContactTest extends TestCase
{

    use RouteTests;

    public function testContact()
    {
        $this->tryRoute('store.contact.index');
    }

}