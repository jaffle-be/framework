<?php

namespace App\Contact\Jobs;

use App\Account\AccountContactInformation;
use App\Jobs\Job;
use App\Theme\ThemeMailer;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Mail\Message;
use Illuminate\Translation\Translator;

//this should probably move to the account module. as its sending a contact mail for the account
//has nothing to do with address info or anything.
class SendContactEmail extends Job implements SelfHandling
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
    }

    /**
     * @param ThemeMailer $mailer
     */
    public function handle(ThemeMailer $mailer, Translator $lang)
    {
        $email = $this->email;
        $name = $this->name;
        $contact = $this->contact;
        $subject = $this->subject;
        $copy = $this->copy;

        //can't use key message, it's being overridden probably by the mailer
        $mailer->send('emails.contact.contact', ['contact_message' => $this->message, 'email' => $this->email, 'name' => $this->name], function (Message $message) use ($lang, $email, $name, $contact, $subject, $copy) {
            $message->from($email, $name);
            $message->to($contact->email);
            $message->subject($lang->get('contact::contact.emails.contact.subject') . ': ' . $subject);

            if ($copy) {
                $message->bcc($email, $name);
            }
        });
    }

}