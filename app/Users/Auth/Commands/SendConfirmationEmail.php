<?php namespace App\Users\Auth\Commands;

use App\Commands\Command;

use App\Users\Auth\Tokens\Token;
use App\Users\User;
use Carbon\Carbon;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Translation\Translator;

class SendConfirmationEmail extends Command implements SelfHandling, ShouldBeQueued
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(Mailer $mail, Translator $lang, Carbon $carbon, Hasher $hash)
    {
        $token = $this->createNewToken($carbon, $hash);

        $user = $this->user;

        $subject = $lang->get('users::emails.confirm-email.subject');

        $mail->send('users::emails.confirm-email', [
            'user'  => $user,
            'token' => $token
        ], function ($message) use ($user, $subject) {
            $message->to($user->email);
            $message->subject($subject);
        });
    }

    protected function createNewToken(Carbon $carbon, Hasher $hash)
    {
        $token = new Token();
        $token->type = Token::TYPE_CONFIRMATION;
        $token->value = $hash->make($this->user->email);
        $token->expires_at = $carbon->addDays(3);

        $token->save();

        $this->user->confirmationToken()->associate($token);

        return $this->user->save() ? $token : false;
    }
}