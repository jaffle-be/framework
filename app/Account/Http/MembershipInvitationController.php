<?php namespace App\Account\Http;

use App\Account\MembershipRepository;
use App\Http\Controllers\Controller;

class MembershipInvitationController extends Controller
{

    public function show(MembershipRepository $repository, $invitation)
    {
        $invitation = $repository->findInvitationByToken($invitation);

        if(!$invitation)
        {
            return redirect()->route('store.home');
        }

        return $this->theme->render('auth.register', ['invitation' => $invitation]);
    }
}