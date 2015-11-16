<?php namespace Modules\Users\Auth\Commands;

use App\Jobs\Job;
use Exception;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Log\Writer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Translation\Translator;
use Modules\Account\AccountManager;
use Modules\Theme\ThemeMailer;
use Modules\Users\Auth\Tokens\Token;
use Modules\Users\Contracts\TokenRepositoryInterface;
use Modules\Users\Contracts\UserRepositoryInterface;

class SendResetEmail extends Job implements SelfHandling, ShouldBeQueued
{

    use InteractsWithQueue;

    /**
     * @var
     */
    protected $email;

    protected $account;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($email, AccountManager $manager)
    {
        $this->email = $email;

        $this->account = $manager->account();
    }

    /**
     * @param ThemeMailer              $mail
     * @param TokenRepositoryInterface $tokens
     * @param Translator               $lang
     * @param UserRepositoryInterface  $users
     */
    public function handle(ThemeMailer $mail, TokenRepositoryInterface $tokens, Translator $lang, UserRepositoryInterface $users, Writer $log)
    {
        $this->setup();

        try {
            $user = $users->findUserByEmail($this->email);

            if ($user) {

                $token = $tokens->createNewToken(Token::TYPE_RESET, $this->email);

                $user->resetToken()->associate($token);

                $user->save();

                $subject = $lang->get('users::emails.reset-password.subject');

                $log->info('just before send');

                $send = $mail->send('users::emails.reset-password', [
                    'user'    => $user,
                    'token'   => $token,
                    'account' => $this->account,
                ], function ($message) use ($user, $subject) {
                    $message->from($this->job->email_from(), $this->job->email_from_name());
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
