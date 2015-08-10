<?php namespace App\Users\Http;

use App\Account\AccountManager;
use App\Account\Team;
use App\System\Http\Controller;
use App\Users\User;

class TeamController extends Controller
{

    public function index(AccountManager $accountManager, Team $team)
    {
        $account = $accountManager->account();

        $memberships = $account->memberships;

        $memberships->load('teams', 'member');

        $teams = $team->whereHas('memberships', function($query){
            $query->whereNotNull('id');
        }, '>=')->get();

        return $this->theme->render('team.index', ['memberships' => $memberships, 'teams' => $teams]);
    }

    public function show(User $team)
    {
        $team->load(['projects', 'projects.images']);

        return $this->theme->render('team.detail', ['member' => $team]);
    }

}