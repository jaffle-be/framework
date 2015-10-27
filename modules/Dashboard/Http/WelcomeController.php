<?php namespace Modules\Dashboard\Http;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Modules\Account\MembershipInvitation;
use Modules\Media\Media;
use Modules\System\Http\FrontController;
use Modules\Theme\Theme;

class WelcomeController extends FrontController
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
