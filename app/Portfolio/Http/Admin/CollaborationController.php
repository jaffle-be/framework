<?php namespace App\Portfolio\Http\Admin;

use App\Account\AccountManager;
use App\Http\Controllers\AdminController;
use App\Portfolio\Project;
use Illuminate\Http\Request;

class CollaborationController extends AdminController
{

    public function index(Project $portfolio, AccountManager $manager)
    {
        $account = $manager->account();

        $members = $account->members;

        foreach($members as $member)
        {
            $member->selected = $portfolio->collaborators->contains($member->id);
        }

        $members->load(['images']);

        return $members;
    }

    public function store(Project $portfolio, Request $request)
    {
        $status = $request->get('status');

        if($status)
        {
            $portfolio->collaborators()->attach($request->get('member'));
        }
        else
        {
            $portfolio->collaborators()->detach($request->get('member'));
        }
    }

    public function destroy(Project $portfolio)
    {

    }

}