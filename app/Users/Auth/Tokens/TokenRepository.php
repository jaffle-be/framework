<?php namespace App\Users\Auth\Tokens;

use App\Users\Contracts\TokenRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Contracts\Hashing\Hasher;

class TokenRepository implements TokenRepositoryInterface
{

    /**
     * @var Token
     */
    protected $token;

    /**
     * @var Hasher
     */
    protected $hasher;

    /**
     * @var Carbon
     */
    protected $carbon;

    public function __construct(Token $token, Hasher $hasher, Carbon $carbon)
    {
        $this->token = $token;
        $this->hasher = $hasher;
        $this->carbon = $carbon;
    }

    public function createNewToken($type, $value, $expires = 2)
    {
        if ($this->validate($type)) {
            $token = new Token();

            $token->type = $type;
            $token->value = $this->hash($value);
            $token->expires_at = $this->carbon->addHours($expires);

            return $token->save() ? $token : false;
        }

        return false;
    }

    public function findTokenByValue($value)
    {
        return $this->token->newQuery()->where('value', $value)->first();
    }

    protected function validate($type)
    {
        return in_array($type, [
            Token::TYPE_CONFIRMATION,
            Token::TYPE_RESET
        ]);
    }

    /**
     * Return a hash that has no / in it suited for url generated
     *
     * @param $value
     */
    protected function hash($value)
    {
        $hash = $this->hasher->make($value);

        while (strpos('/', $hash) !== false) {
            $hash = $this->hasher->make($value);
        }

        return $hash;
    }
}