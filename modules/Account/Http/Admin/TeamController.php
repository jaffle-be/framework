<?php namespace Modules\Account\Http\Admin;

use Illuminate\Http\Request;
use Modules\Account\AccountManager;
use Modules\Account\Membership;
use Modules\Account\Team;
use Modules\System\Http\AdminController;

class TeamController extends AdminController
{

    public function index(Team $team)
    {
        return $team->with(['translations'])->get();
    }

    public function toggleMembership(Team $teams, $team, Request $request, Membership $membership)
    {
        $membership = $membership->find($request->get('membership'));

        if (!$membership) {
            return json_encode(array(
                'status' => 'noke'
            ));
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

    public function store(Request $request, Team $team, AccountManager $manager)
    {
        $team->account()->associate($manager->account());
        $team->fill($request->get('translations'));
        $team->save();

        return $team;
    }

    public function destroy($team, Team $teams)
    {
        $team = $teams->find($team);

        if ($team && $team->delete()) {
            $team->id = false;

            return $team;
        }
    }

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