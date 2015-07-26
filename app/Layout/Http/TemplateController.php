<?php namespace App\Layout\Http;

use App\Account\AccountManager;
use App\Http\Controllers\AdminController;
use Illuminate\Contracts\Auth\Guard;

class TemplateController extends AdminController
{

    public function template($template, Guard $guard, AccountManager $manager)
    {
        $user = $guard->user();

        return view('layout::admin.' . $template, [
            'user' => $user,
            'account' => $manager->account()
        ]);
    }
}