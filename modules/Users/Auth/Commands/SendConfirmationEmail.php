<?php namespace Modules\Users\Auth\Commands;

use App\Jobs\EmailJob;
use Illuminate\Translation\Translator;
use Modules\Theme\ThemeMailer;
use Modules\Users\Auth\Tokens\Token;
use Modules\Users\Contracts\TokenRepositoryInterface;
use Modules\Users\User;

class SendConfirmationEmail extends EmailJob
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
        parent::__construct();
    }

    public function handle(ThemeMailer $mail, Translator $lang, TokenRepositoryInterface $tokens)
    {
        try {
            $token = $tokens->createNewToken(Token::TYPE_CONFIRMATION, $this->user->email);

            if ($token) {
                $user = $this->user;

                $user->confirmationToken()->associate($token);

                $subject = $lang->get('users::emails.confirm-email.subject');

                $data = array_merge($this->baseData(), [
                    'user'    => $user,
                    'token'   => $token,
                    'email_to' => $user->email,
                ]);

                $send = $mail->send('users::emails.confirm-email', $data, $subject);

                if ($send) {

                    $this->delete();
                }

                $user->save();
            }
        }

        catch (\Exception $e) {
            $this->release();

            throw $e;
        }
    }
}