<?php

namespace Test\Auth;

use Modules\Users\Auth\Tokens\Token;
use Test\FrontTestCase;
use Test\Routes\RouteTests;

class AuthTest extends FrontTestCase
{
    use RouteTests;

    public function testSignin()
    {
        $this->tryRoute('store.auth.signin.index');
    }

    public function testSignup()
    {
        $this->tryRoute('store.auth.signup.index');
    }

    public function testSignout()
    {
        $response = $this->call('GET', store_route('store.auth.signout.index'));
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testConfirmEmail()
    {
        //        $this->tryRoute('store.auth.confirm-email.show');
    }

    public function testForgotPassword()
    {
        $this->tryRoute('store.auth.forgot-password.index');
    }

    public function testResetPassword()
    {
        $token = factory(Token::class, 'reset')->create();

        $this->tryRoute('store.auth.reset-password.show', [$token]);
    }
}
