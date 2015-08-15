<?php namespace App\Account\Http\Admin;

use App\Account\AccountManager;
use App\Account\Membership;
use App\Account\Team;
use App\System\Http\AdminController;
use Illuminate\Http\Request;

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

        if($team)
        {
            $team->fill(translation_input($request, ['name']));
            $team->save();

            return $team;
        }
    }

}