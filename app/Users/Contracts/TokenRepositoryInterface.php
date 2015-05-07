<?php namespace App\Users\Contracts;

interface TokenRepositoryInterface {

    public function findTokenByValue($value);

}