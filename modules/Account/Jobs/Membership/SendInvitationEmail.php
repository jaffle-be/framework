<?php namespace Modules\Account\Jobs\Membership;

use App\Jobs\EmailJob;
use Illuminate\Translation\Translator;
use Modules\Account\MembershipInvitation;
use Modules\Theme\ThemeMailer;

class SendInvitationEmail extends EmailJob
{
    protected $invitation;

    public function __construct(MembershipInvitation $invitation)
    {
        $this->invitation = $invitation;
        parent::__construct();
    }

    public function handle(ThemeMailer $mailer, Translator $lang)
    {
        $data = array_merge($this->baseData(), [
            'invitation' => $this->invitation,
            'email_to' => $this->invitation->email
        ]);

        return $mailer->send('account::admin.members.invitation.email', $data, $lang->get('account::admin.users.you-are-invited'));
    }

}