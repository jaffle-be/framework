<?php

namespace Modules\Portfolio\Http\Admin;

use Illuminate\Http\Request;
use Modules\Account\AccountManager;
use Modules\Portfolio\Project;
use Modules\System\Http\AdminController;

/**
 * Class CollaborationController
 * @package Modules\Portfolio\Http\Admin
 */
class CollaborationController extends AdminController
{
    /**
     * @param Project $portfolio
     * @param AccountManager $manager
     * @return mixed
     */
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

    /**
     * @param Project $portfolio
     * @param Request $request
     */
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
