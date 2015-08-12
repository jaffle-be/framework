<?php namespace App\Theme\Http\Admin;

use App\Account\Account;
use App\Account\AccountManager;
use App\System\Http\AdminController;
use App\Theme\ThemeManager;
use App\Theme\ThemeSelection;
use App\Theme\ThemeSettingOption;
use Illuminate\Http\Request;

class ThemeController extends AdminController
{

    public function index()
    {
        $themes = $this->theme->supported();

        $current = $this->theme->current();

        foreach ($themes as $theme) {
            $theme->active = false;

            if ($current && $theme->id == $current->id) {
                $theme->active = true;
            }
        }

        return $themes;
    }

    public function settings(AccountManager $manager)
    {
        $themes = $this->theme->supported();

        return view('theme::admin.settings', [
            'themes'  => $themes,
            'account' => $manager->account(),
            'current' => $this->theme->current(),
        ]);
    }

    public function setting($theme, $setting, ThemeManager $themes, Request $request, ThemeSettingOption $option, AccountManager $accounts)
    {
        $current = $themes->current();

        $account = $accounts->account();

        $selection = $themes->selection();

        if ($current && $current->id == $theme) {
            $settings = $current->settings->keyBy('id');

            $setting = $settings->get($setting);

            switch ($setting->getType()) {
                case 'boolean':
                    $this->updateSettingBoolean($setting, $request, $account, $selection);
                    break;
                case 'string':
                case 'text':
                    $this->updateSettingString($setting, $request, $account, $selection);
                    break;
                case 'select':
                    $this->updateSettingSelect($setting, $request, $option, $account, $selection);
                    break;
            }
        }
    }

    public function activate($theme, AccountManager $account)
    {
        if ($this->theme->activate($theme, $account)) {
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

        $theme->load(['settings', 'settings.options', 'settings.value', 'settings.value.translations']);

        return $theme;
    }

    /**
     * @param         $setting
     * @param Request $request
     * @param         $account
     */
    protected function updateSettingBoolean($setting, Request $request, Account $account, ThemeSelection $selection)
    {
        $checked = $request->get('checked');

        $setting->value()->delete();

        if ($checked) {
            $setting->value()->create([
                'value'        => true,
                'account_id'   => $account->id,
                'selection_id' => $selection->id,
            ]);
        }
    }

    /**
     * @param                    $setting
     * @param Request            $request
     * @param ThemeSettingOption $option
     * @param                    $account
     */
    protected function updateSettingSelect($setting, Request $request, ThemeSettingOption $option, Account $account, ThemeSelection $selection)
    {
        $option = $option->find($request->get('option'));

        $setting->value()->delete();

        $setting->value()->create([
            'option_id'  => $option->id,
            'account_id' => $account->id,
            'selection_id' => $selection->id,
        ]);
    }

    protected function updateSettingString($setting, $request, Account $account, ThemeSelection $selection)
    {
        $value = $setting->value;

        $input = translation_input($request, []);

        if (!$value) {

            $input = array_merge(['account_id' => $account->id, 'selection_id' => $selection->id], $input);

            return $setting->value()->create($input);
        }

        $value->fill($input);

        $value->save();
    }

}