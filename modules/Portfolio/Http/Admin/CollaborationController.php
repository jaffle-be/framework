<?php namespace Modules\Portfolio\Http\Admin;

use Illuminate\Http\Request;
use Modules\Account\AccountManager;
use Modules\Portfolio\Project;
use Modules\System\Http\AdminController;

class CollaborationController extends AdminController
{

    public function index(Project $portfolio, AccountManager $manager)
    {
        $account = $manager->account();

        $members = $account->members;

        foreach ($members as $member) {
            $member->selected = $portfolio->collaborators->contains($member->id);
        }

        $members->load(['images']);

        return $members;
    }

    public function store(Project $portfolio, Request $request)
    {
        $status = $request->get('status');

        if ($status) {
            $portfolio->collaborators()->attach($request->get('member'));
        } else {
            $portfolio->collaborators()->detach($request->get('member'));
        }
    }

}