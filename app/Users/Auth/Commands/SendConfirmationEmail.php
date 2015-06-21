<?php namespace App\Users\Auth\Commands;

use App\Jobs\Job;
use App\Users\Auth\Tokens\Token;
use App\Users\Contracts\TokenRepositoryInterface;
use App\Users\User;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Translation\Translator;

class SendConfirmationEmail extends Job implements SelfHandling, ShouldBeQueued
{
    use InteractsWithQueue;

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

        if($token)
        {
            $user = $this->user;

            $user->confirmationToken()->associate($token);

            $subject = $lang->get('users::emails.confirm-email.subject');

            $send = $mail->send('users::emails.confirm-email', [
                'user'  => $user,
                'token' => $token
            ], function ($message) use ($user, $subject) {
                $message->to($user->email);
                $message->subject($subject);
            });

            if($send)
            {
                $this->delete();
            }

            $user->save();
        }
    }
}