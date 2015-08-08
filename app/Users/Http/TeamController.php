<?php namespace App\Users\Http;

use App\Account\AccountManager;
use App\System\Http\Controller;
use App\Users\User;

class TeamController extends Controller
{

    public function index(AccountManager $accountManager)
    {
        $account = $accountManager->account();

        $members = $account->members;

        return $this->theme->render('team.index', ['members' => $members]);
    }

    public function show(User $team)
    {
        $team->load(['projects', 'projects.images']);

        return $this->theme->render('team.detail', ['member' => $team]);
    }

}