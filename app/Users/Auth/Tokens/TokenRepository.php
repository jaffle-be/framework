<?php namespace App\Users\Auth\Tokens;

use App\Users\Contracts\TokenRepositoryInterface;

class TokenRepository implements TokenRepositoryInterface{

    protected $token;

    public function __construct(Token $token)
    {
        $this->token = $token;
    }

    public function findTokenByValue($value)
    {
        return $this->token->newQuery()->where('value', $value)->first();
    }
}