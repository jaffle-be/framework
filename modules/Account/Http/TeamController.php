<?php

namespace Modules\Account\Http;

use Modules\Account\AccountManager;
use Modules\Account\Team;
use Modules\Blog\PostRepositoryInterface;
use Modules\System\Http\FrontController;
use Modules\Users\User;

class TeamController extends FrontController
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

    public function show(User $user, $team, PostRepositoryInterface $posts)
    {
        $user = $user->find($team);

        $user = $user->load(['images', 'socialLinks', 'skills', 'projects', 'projects.images']);

        $posts = $posts->getAuthorArticles($user);

        return $this->theme->render('team.detail', ['member' => $user, 'posts' => $posts]);
    }

    protected function memberRelations($prefix = null)
    {
        $relations = ['member.socialLinks', 'member.skills', 'member.skills.translations'];

        array_walk($relations, function (&$value) use ($prefix) {
            $value = $prefix.$value;
        });

        return $relations;
    }
}
