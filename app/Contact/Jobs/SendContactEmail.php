<?php

namespace App\Contact\Jobs;

use App\Account\Account;
use App\Account\AccountContactInformation;
use App\Jobs\Job;
use App\Theme\ThemeMailer;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;

//this should probably move to the account module. as its sending a contact mail for the account
//has nothing to do with address info or anything.
class SendContactEmail extends Job implements SelfHandling, ShouldBeQueued
{

    use InteractsWithQueue;

    protected $account;

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
     * @param                           $name
     * @param                           $email
     * @param                           $message
     * @param null                      $subject
     * @param null                      $copy
     */
    public function __construct(Account $account, AccountContactInformation $contact, $name, $email, $message, $subject = null, $copy = null)
    {
        $this->account = $account;
        $this->contact = $contact;
        $this->name = $name;
        $this->email = $email;
        $this->message = $message;
        $this->subject = $subject;
        $this->copy = $copy;
    }

    public function handle(ThemeMailer $mailer)
    {
        $this->setup();

        $email = $this->email;
        $name = $this->name;
        $contact = $this->contact;
        $subject = $this->subject;
        $copy = $this->copy;

        //can't use the key 'message', it's being overridden probably by the mailer
        $payload = [
            'account' => $this->account,
            'contact_message' => $this->message,
            'subject' => $subject,
            'email' => $this->email,
            'name' => $this->name
        ];

        $callback = function (Message $message) use ($email, $name, $contact, $subject, $copy) {
            $message->from($email, $name);
            $message->to($contact->email);
            $message->subject($subject);

            if ($copy) {
                $message->bcc($email, $name);
            }
        };

        $mailer->send('contact::email', $payload, $callback);
    }

}