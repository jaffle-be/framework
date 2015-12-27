<?php

namespace Modules\Account\Jobs\Membership;

use App\Jobs\EmailJob;
use Illuminate\Translation\Translator;
use Modules\Account\MembershipInvitation;
use Modules\Theme\ThemeMailer;

/**
 * Class SendInvitationEmail
 * @package Modules\Account\Jobs\Membership
 */
class SendInvitationEmail extends EmailJob
{
    protected $invitation;

    /**
     * @param MembershipInvitation $invitation
     */
    public function __construct(MembershipInvitation $invitation)
    {
        $this->invitation = $invitation;
        parent::__construct();
    }

    /**
     * @param ThemeMailer $mailer
     * @param Translator $lang
     */
    public function handle(ThemeMailer $mailer, Translator $lang)
    {
        $data = array_merge($this->baseData(), [
            'invitation' => $this->invitation,
            'email_to' => $this->invitation->email,
        ]);

        return $mailer->send('account::admin.members.invitation.email', $data, $lang->get('account::admin.users.you-are-invited'));
    }
}
