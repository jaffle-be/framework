<?php namespace App\Theme\Http\Admin;

use App\Account\AccountManager;
use App\Http\Controllers\AdminController;
use App\Theme\Theme;
use App\Theme\ThemeManager;
use App\Theme\ThemeSettingOption;
use Illuminate\Http\Request;
use Illuminate\Session\Store;

class ThemeController extends AdminController
{

    public function index()
    {
        $themes = $this->theme->supported();

        $current = $this->theme->current();

        foreach($themes as $theme)
        {
            $theme->active = false;

            if($current && $theme->id == $current->id)
            {
                $theme->active = true;
            }
        }

        return $themes;
    }

    public function settings(AccountManager $manager)
    {
        $themes = $this->theme->supported();

        return view('theme::admin.settings', [
            'themes' => $themes,
            'account' => $manager->account(),
            'current' => $this->theme->current(),
        ]);
    }

    public function setting($theme, ThemeManager $themes, Request $request, ThemeSettingOption $option, AccountManager $accounts)
    {
        $current = $themes->current();

        $account = $accounts->account();

        if($current && $current->id == $theme)
        {
            $settings = $current->settings->keyBy('id');

            $option = $option->find($request->get('option'));

            $setting = $settings->get($option->key_id);

            $setting->value()->delete();

            $setting->value()->create([
                'option_id' => $option->id,
                'account_id' => $account->id
            ]);
        }
    }

    public function activate($theme, AccountManager $account)
    {
        if($this->theme->activate($theme, $account))
        {
            return json_encode(array(
                'status' => 'oke'
            ));
        }

        return json_encode(array(
            'status' => 'noke'
        ));
    }

    public function current(ThemeManager $theme)
    {
        $theme = $theme->current();

        $theme->load(['settings', 'settings.options', 'settings.value']);

        return $theme;
    }

}