<?php

namespace Modules\Users\Auth\Commands;

use App\Jobs\EmailJob;
use Exception;
use Illuminate\Translation\Translator;
use Modules\Theme\ThemeMailer;
use Modules\Users\Auth\Tokens\Token;
use Modules\Users\Contracts\TokenRepositoryInterface;
use Modules\Users\Contracts\UserRepositoryInterface;

class SendResetEmail extends EmailJob
{
    /**
     * @var
     */
    protected $email;

    /**
     * Create a new command instance.
     *
     *
     */
    public function __construct($email)
    {
        $this->email = $email;

        parent::__construct();
    }

    /**
     *
     *
     *
     *
     *
     * @throws Exception
     */
    public function handle(ThemeMailer $mail, TokenRepositoryInterface $tokens, Translator $lang, UserRepositoryInterface $users)
    {
        try {
            $user = $users->findUserByEmail($this->email);

            if ($user) {
                $token = $tokens->createNewToken(Token::TYPE_RESET, $this->email);

                $user->resetToken()->associate($token);

                $user->save();

                $subject = $lang->get('users::emails.reset-password.subject');

                $data = array_merge($this->baseData(), [
                    'user' => $user,
                    'token' => $token,
                    'email_to' => $this->email,
                ]);

                $send = $mail->send('users::emails.reset-password', $data, $subject);

                if ($send) {
                    $this->delete();
                }
            }
        } catch (Exception $e) {
            $this->release();

            throw $e;
        }
    }
}
