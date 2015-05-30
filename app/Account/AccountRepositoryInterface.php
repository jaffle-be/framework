<?php namespace App\Account;

interface AccountRepositoryInterface {

    public function newAccount(array $payload);

}