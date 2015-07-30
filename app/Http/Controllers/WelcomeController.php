<?php namespace App\Http\Controllers;

use App\Account\MembershipInvitation;
use App\Media\Media;
use App\Theme\Theme;
use Illuminate\Foundation\Bus\DispatchesCommands;
use App\Media\Commands\StoreNewImage;
use Illuminate\Http\Request;
use Illuminate\Session\Store;

class WelcomeController extends Controller
{
    use DispatchesCommands;

    public function storeHome()
    {
        return $this->theme->render('home.index');
    }

    public function storeDash(Store $session, Request $request)
    {
        $this->middleware('auth.admin');

        return view('layouts.back', ['theme' => $this->theme->current()]);
    }

    public function system()
    {
        $config = config('translatable');

        $config = [
            'locale' => \App::getLocale(),
            'fallback_locale' => $config['fallback_locale'],
            'locales' => $config['locales'],
            'user' => \Auth::user(),
            'rpp' => 40
        ];

        return $config;
    }

    public function test(Theme $theme)
    {
        return view('account::admin.members.invitation.email', [
            'theme' => $theme,
            'theme_template' => config('theme.email_template'),
            'invitation' => MembershipInvitation::first()
        ]);
    }
}
