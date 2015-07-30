<?php namespace App\Layout\Http;

use App\Account\AccountManager;
use App\Http\Controllers\AdminController;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Session\Store;

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