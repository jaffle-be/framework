<?php namespace Modules\Dashboard\Http;

use Cookie;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Modules\Account\AccountManager;
use Modules\Account\MembershipInvitation;
use Modules\Media\Media;
use Modules\System\Http\FrontController;
use Modules\Theme\Theme;

class WelcomeController extends FrontController
{
    use DispatchesCommands;

    /**
     * This route is only valid for multi locale applications.
     *
     * @param Request        $request
     * @param AccountManager $manager
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function landing(Request $request, AccountManager $manager)
    {
        if($request->hasCookie('locale'))
        {
            return redirect()->to(store_route('store.home', [], [], $request->cookie('locale')));
        }

        if($manager->account()->locales->count() == 1)
        {
            return redirect()->to(store_route('store.home'));
        }

        return $this->theme->render('home.landing');
    }

    public function storeHome()
    {
        $tweets = latest_tweets_about(3);

        return $this->theme->render('home.index', ['tweets' => $tweets]);
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
