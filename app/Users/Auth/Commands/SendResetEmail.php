<?php namespace App\Users\Auth\Commands;

use App\Commands\Command;
use App\Users\Auth\Tokens\Token;
use App\Users\Contracts\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Translation\Translator;

class SendResetEmail extends Command implements SelfHandling, ShouldBeQueued
{

    /**
     * @var
     */
    protected $email;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Execute the command.
     *
     * @param Mailer                  $mail
     * @param Carbon                  $carbon
     * @param Translator              $lang
     * @param Hasher                  $hash
     * @param UserRepositoryInterface $users
     */
    public function handle(Mailer $mail, Carbon $carbon, Translator $lang, Hasher $hash, UserRepositoryInterface $users)
    {
        $user = $users->findUserByEmail($this->email);

        if ($user) {
            $token = $this->createNewToken($carbon, $hash);

            $user->resetToken()->associate($token);

            $user->save();

            $subject = $lang->get('users::emails.reset-password.subject');

            $mail->send('users::emails.reset-password', [
                'user'  => $user,
                'token' => $token
            ], function ($message) use ($user, $subject) {
                $message->to($user->email);
                $message->subject($subject);
            });
        }
    }

    protected function createNewToken($carbon, $hash)
    {
        $token = new Token();

        $token->type = Token::TYPE_RESET;
        $token->value = $hash->make($this->email);
        $token->expires_at = $carbon->addHours(2);

        return $token->save() ? $token : false;
    }
}
