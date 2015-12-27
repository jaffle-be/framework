<?php

namespace Modules\Contact\Jobs;

use App\Jobs\EmailJob;
use Illuminate\Mail\Message;
use Modules\Account\AccountContactInformation;
use Modules\Theme\ThemeMailer;

//this should probably move to the account module. as its sending a contact mail for the account
//has nothing to do with address info or anything.
/**
 * Class SendContactEmail
 * @package Modules\Contact\Jobs
 */
class SendContactEmail extends EmailJob
{
    /**
     * @var AccountContactInformation
     */
    protected $contact;

    /**
     * @var
     */
    protected $name;

    /**
     * @var
     */
    protected $email;

    /**
     * @var
     */
    protected $message;

    /**
     * @var null
     */
    protected $subject;

    /**
     * @var null
     */
    protected $copy;

    /**
     * @param AccountContactInformation $contact
     * @param $name
     * @param $email
     * @param $message
     * @param null $subject
     * @param null $copy
     */
    public function __construct(AccountContactInformation $contact, $name, $email, $message, $subject = null, $copy = null)
    {
        $this->contact = $contact;
        $this->name = $name;
        $this->email = $email;
        $this->message = $message;
        $this->subject = $subject;
        $this->copy = $copy;
        parent::__construct();
    }

    /**
     * @param ThemeMailer $mailer
     */
    public function handle(ThemeMailer $mailer)
    {
        //can't use the key 'message', it's being overridden probably by the mailer
        $data = array_merge([
            'email_from' => $this->email,
            'email_from_name' => $this->name,
            'email_to' => $this->contact->email,
            'contact_message' => $this->message,
            'subject' => $this->subject,
            'email' => $this->email,
            'name' => $this->name,
        ], $this->baseData());

        $me = $this;

        $mailer->send('contact::email', $data, function ($message) use ($me) {
            /* @var Message $message */
            $message->subject($me->subject);

            if ($me->copy) {
                $message->cc($me->copy, $me->name);
            }
        });
    }
}
