<?php namespace App\Account\Http;

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

        //make sure to test all templates when changing these relations.
        //some templates show data by running through teams and others by running through memberships
        $memberships->load(['member', 'member.images', 'member.socialLinks', 'member.skills', 'member.skills.translations']);

        $teams = $team->with(['memberships', 'translations'])->whereHas('memberships', function ($query) {
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

    protected function memberRelations($prefix = null)
    {
        $relations = ['member.socialLinks', 'member.skills', 'member.skills.translations'];

        array_walk($relations, function (&$value) use ($prefix) {
            $value = $prefix . $value;
        });

        return $relations;
    }

}