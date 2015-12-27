<?php

namespace Modules\Account\Http\Admin;

use Illuminate\Http\Request;
use Modules\Account\AccountManager;
use Modules\Account\Membership;
use Modules\Account\Team;
use Modules\System\Http\AdminController;

/**
 * Class TeamController
 * @package Modules\Account\Http\Admin
 */
class TeamController extends AdminController
{
    /**
     * @param Team $team
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index(Team $team)
    {
        return $team->with(['translations'])->get();
    }

    /**
     * @param Team $teams
     * @param $team
     * @param Request $request
     * @param Membership $membership
     * @return string
     */
    public function toggleMembership(Team $teams, $team, Request $request, Membership $membership)
    {
        $membership = $membership->find($request->get('membership'));

        if (! $membership) {
            return json_encode([
                'status' => 'noke',
            ]);
        }

        $team = $teams->find($team);

        if ($request->get('status')) {
            $membership
                ->teams()
                ->attach($team);
        } else {
            $membership
                ->teams()
                ->detach($team);
        }
    }

    /**
     * @param Request $request
     * @param Team $team
     * @param AccountManager $manager
     * @return Team
     */
    public function store(Request $request, Team $team, AccountManager $manager)
    {
        $team->account()->associate($manager->account());
        $team->fill($request->get('translations'));
        $team->save();

        return $team;
    }

    /**
     * @param $team
     * @param Team $teams
     * @return mixed
     */
    public function destroy($team, Team $teams)
    {
        $team = $teams->find($team);

        if ($team && $team->delete()) {
            $team->id = false;

            return $team;
        }
    }

    /**
     * @param $team
     * @param Team $teams
     * @param Request $request
     * @return mixed
     */
    public function update($team, Team $teams, Request $request)
    {
        $team = $teams->find($team);

        if ($team) {
            $team->fill(translation_input($request, ['name']));
            $team->save();

            return $team;
        }
    }
}
