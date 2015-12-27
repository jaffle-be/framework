<?php

namespace Modules\System\Http;

use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Modules\Account\Account;
use Modules\Account\AccountManager;

/**
 * Class SystemController
 * @package Modules\System\Http
 */class SystemController extends FrontController
{
    /**
* @param Store $session
* @param Request $request
* @param AccountManager $accounts
 * @return \Illuminate\Http\RedirectResponse
*/public function locale(Store $session, Request $request, AccountManager $accounts)
    {
        $account = $accounts->account();

        if ($request->has('locale') && $this->is_account_locale($account, $request->get('locale'))) {
            $session->set('locale', $request->get('locale'));

            return redirect()->to('/'.$request->get('locale'));
        }

        return redirect()->to(store_route('store.home'));
    }

    /**
* @param Account $account
* @param $locale
* @return
*/    protected function is_account_locale(Account $account, $locale)
    {
        return $account->locales->filter(function ($item) use ($locale) {
            return $item->slug == $locale;
        })->first();
    }
}
