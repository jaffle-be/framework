<?php

namespace Modules\Dashboard\Http;

use Cookie;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Modules\Account\AccountManager;
use Modules\Account\MembershipInvitation;
use Modules\System\Http\FrontController;
use Modules\Theme\Theme;

/**
 * Class WelcomeController
 * @package Modules\Dashboard\Http
 */
class WelcomeController extends FrontController
{
    /**
     * This route is only valid for multi locale applications.
     *
     * @param Request $request
     * @param AccountManager $manager
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function landing(Request $request, AccountManager $manager)
    {
        if ($manager->account()->locales->count() == 1) {
            return redirect()->to(store_route('store.home'));
        }

        if ($request->hasCookie('locale')) {
            return redirect()->to(store_route('store.home', [], [], $request->cookie('locale')));
        }

        return $this->theme->render('home.landing');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function storeHome()
    {
        $tweets = latest_tweets_about(3);

        return $this->theme->render('home.index', ['tweets' => $tweets]);
    }

    /**
     * @param Store $session
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function storeDash(Store $session, Request $request)
    {
        $this->middleware('auth.admin');

        return view('layouts.back', ['theme' => $this->theme->current()]);
    }

    /**
     * @return array|mixed
     */
    public function system()
    {
        $config = config('translatable');

        $config = [
            'locale' => \App::getLocale(),
            'fallback_locale' => $config['fallback_locale'],
            'locales' => $config['locales'],
            'user' => \Auth::user(),
            'rpp' => 40,
        ];

        return $config;
    }

    /**
     * @param Theme $theme
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function test(Theme $theme)
    {
        return view('account::admin.members.invitation.email', [
            'theme' => $theme,
            'theme_template' => config('theme.email_template'),
            'invitation' => MembershipInvitation::first(),
        ]);
    }
}
