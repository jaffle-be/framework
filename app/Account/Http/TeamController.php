<?php namespace App\Account\Http;

use App\Account\AccountManager;
use App\Account\Team;
use App\System\Http\Controller;
use App\Users\User;
use Illuminate\Http\Request;

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

    public function show(User $user, $team)
    {
        $user = $user->find($team);

        $user = $user->load(['projects', 'projects.images']);

        return $this->theme->render('team.detail', ['member' => $user]);
    }

}