<?php namespace App\System\Http;

use App\Account\Account;
use App\Account\AccountManager;
use Illuminate\Http\Request;
use Illuminate\Session\Store;

class SystemController extends FrontController
{

    public function locale(Store $session, Request $request, AccountManager $accounts)
    {
        $account = $accounts->account();

        if($request->has('locale') && $this->is_account_locale($account, $request->get('locale')))
        {
            $session->set('locale', $request->get('locale'));
        }

        return redirect()->route('store.home');
    }

    /**
     * @param $account
     *
     * @return mixed
     */
    protected function is_account_locale(Account $account, $locale)
    {
        return $account->locales->filter(function($item) use ($locale){
            return $item->slug == $locale;
        })->first();
    }

}