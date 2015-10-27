<?php namespace Modules\Layout\Http;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Session\Store;
use Modules\Account\AccountManager;
use Modules\System\Http\AdminController;

class TemplateController extends AdminController
{

    public function template($template, Guard $guard, AccountManager $manager, Store $session)
    {
        $user = $guard->user();

        return view('layout::admin.' . $template, [
            'user' => $user,
            'account' => $manager->account(),
            'theme' => $this->theme->current(),
        ]);
    }
}