<?php namespace App\Users\Auth\Commands;

use App\Commands\Command;
use App\Users\Auth\Tokens\Token;
use App\Users\Contracts\TokenRepositoryInterface;
use App\Users\Contracts\UserRepositoryInterface;
use Exception;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Log\Writer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Translation\Translator;

class SendResetEmail extends Command implements SelfHandling, ShouldBeQueued
{

    use InteractsWithQueue;

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
     * @param Mailer                   $mail
     * @param TokenRepositoryInterface $tokens
     * @param Translator               $lang
     * @param UserRepositoryInterface  $users
     */
    public function handle(Mailer $mail, TokenRepositoryInterface $tokens, Translator $lang, UserRepositoryInterface $users, Writer $log)
    {
        try {
            $user = $users->findUserByEmail($this->email);

            if ($user) {

                $token = $tokens->createNewToken(Token::TYPE_RESET, $this->email);

                $user->resetToken()->associate($token);

                $user->save();

                $subject = $lang->get('users::emails.reset-password.subject');

                $log->info('just before send');

                $send = $mail->send('users::emails.reset-password', [
                    'user'  => $user,
                    'token' => $token
                ], function ($message) use ($user, $subject) {
                    $message->to($user->email);
                    $message->subject($subject);
                });

                if ($send) {
                    $this->delete();
                }

            }
        }
        catch (Exception $e) {
            $message = sprintf('Error sending reset mail\nmessage:%s\nfile:%s\nline:%s', $e->getMessage(), $e->getFile(), $e->getLine());

            $log->error($message);
        }
    }

}
