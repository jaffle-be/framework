<?php

namespace Modules\System\Http;

use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Modules\Account\Account;
use Modules\Account\AccountManager;

class SystemController extends FrontController
{
    public function locale(Store $session, Request $request, AccountManager $accounts)
    {
        $account = $accounts->account();

        if ($request->has('locale') && $this->is_account_locale($account, $request->get('locale'))) {
            $session->set('locale', $request->get('locale'));

            return redirect()->to('/'.$request->get('locale'));
        }

        return redirect()->to(store_route('store.home'));
    }

    /**
     *
     *
     *
     * @return mixed
     */
    protected function is_account_locale(Account $account, $locale)
    {
        return $account->locales->filter(function ($item) use ($locale) {
            return $item->slug == $locale;
        })->first();
    }
}
