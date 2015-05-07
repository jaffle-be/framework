<?php namespace App\Users\Auth\Commands;

use App\Commands\Command;
use App\Users\Auth\Tokens\Token;
use App\Users\Contracts\TokenRepositoryInterface;
use App\Users\User;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Translation\Translator;

class SendConfirmationEmail extends Command implements SelfHandling, ShouldBeQueued
{

    /**
     * @var User
     */
    protected $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param Mailer                   $mail
     * @param Translator               $lang
     * @param TokenRepositoryInterface $tokens
     */
    public function handle(Mailer $mail, Translator $lang, TokenRepositoryInterface $tokens)
    {
        $token = $tokens->createNewToken(Token::TYPE_CONFIRMATION, $this->user->email);

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
}