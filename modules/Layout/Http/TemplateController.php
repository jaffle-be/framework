<?php

namespace Modules\Layout\Http;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Session\Store;
use Modules\Account\AccountManager;
use Modules\System\Http\AdminController;

/**
 * Class TemplateController
 * @package Modules\Layout\Http
 */
class TemplateController extends AdminController
{
    /**
     * @param $template
     * @param Guard $guard
     * @param AccountManager $manager
     * @param Store $session
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function template($template, Guard $guard, AccountManager $manager, Store $session)
    {
        $user = $guard->user();

        return view('layout::admin.'.$template, [
            'user' => $user,
            'account' => $manager->account(),
            'theme' => $this->theme->current(),
        ]);
    }
}
