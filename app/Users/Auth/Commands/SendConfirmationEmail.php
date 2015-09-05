<?php namespace App\Users\Auth\Commands;

use App\Account\AccountManager;
use App\Jobs\Job;
use App\Theme\ThemeMailer;
use App\Users\Auth\Tokens\Token;
use App\Users\Contracts\TokenRepositoryInterface;
use App\Users\User;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Translation\Translator;

class SendConfirmationEmail extends Job implements SelfHandling, ShouldBeQueued
{

    use InteractsWithQueue, SerializesModels;

    /**
     * @var User
     */
    protected $user;

    protected $account;

    /**
     * @param User $user
     */
    public function __construct(User $user, AccountManager $manager)
    {
        $this->user = $user;
        $this->account = $manager->account();
    }

    public function handle(ThemeMailer $mail, Translator $lang, TokenRepositoryInterface $tokens)
    {
        $this->setupEmailConfig();

        try{
            $token = $tokens->createNewToken(Token::TYPE_CONFIRMATION, $this->user->email);

            if ($token) {
                $user = $this->user;

                $user->confirmationToken()->associate($token);

                $subject = $lang->get('users::emails.confirm-email.subject');

                $send = $mail->send('users::emails.confirm-email', [
                    'user'    => $user,
                    'token'   => $token,
                    'account' => $this->account
                ], function ($message) use ($user, $subject) {
                    $message->to($user->email);
                    $message->subject($subject);
                });

                if ($send) {

                    $this->delete();
                }

                $user->save();
            }
        }

        catch(\Exception $e)
        {
            $this->release();

            throw $e;
        }

    }
}