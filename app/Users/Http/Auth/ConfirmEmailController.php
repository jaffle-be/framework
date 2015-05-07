<?php namespace App\Users\Http\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Users\Auth\Commands\ConfirmEmail;
use App\Users\Contracts\TokenRepositoryInterface;
use Illuminate\Foundation\Bus\DispatchesCommands;

class ConfirmEmailController extends Controller
{
    use DispatchesCommands;

    public function show($token, TokenRepositoryInterface $tokens)
    {
        $token = $tokens->findTokenByValue($token);

        if($token)
        {
            $this->dispatchFromArray(ConfirmEmail::class, ['token' => $token]);
        }

        return redirect()->route('home');
    }
}
