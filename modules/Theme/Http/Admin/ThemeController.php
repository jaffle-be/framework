<?php

namespace Modules\Theme\Http\Admin;

use Illuminate\Http\Request;
use Modules\Account\AccountManager;
use Modules\System\Http\AdminController;
use Modules\Theme\ThemeSettingOption;

/**
 * Class ThemeController
 * @package Modules\Theme\Http\Admin
 */
class ThemeController extends AdminController
{
    /**
     * @return mixed
     */
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

    /**
     * @param AccountManager $manager
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function settings(AccountManager $manager)
    {
        $themes = $this->theme->supported();

        return view('theme::admin.settings', [
            'themes' => $themes,
            'account' => $manager->account(),
            'current' => $this->theme->current(),
        ]);
    }

    /**
     * @param $theme
     * @param $setting
     * @param Request $request
     * @param ThemeSettingOption $option
     */
    public function setting($theme, $setting, Request $request, ThemeSettingOption $option)
    {
        $current = $this->theme->current();

        if ($current && $current->getKey() == $theme) {
            $settings = $current->settings->keyBy('id');

            $setting = $settings->get($setting);

            switch ($setting->type->name) {
                case 'boolean':
                    $this->theme->updateBoolean($setting, $request->get('checked'));
                    break;
                case 'string':
                case 'text':
                    $this->theme->updateString($setting, translation_input($request, []));
                    break;
                case 'select':
                    $this->theme->updateSelect($setting, $request->get('option'), $option);
                    break;
                case 'numeric':
                    $this->theme->updateNumeric($setting, $request->get('value'));
                    break;
            }
        }
    }

    /**
     * @param $theme
     * @return string
     */
    public function activate($theme)
    {
        if ($this->theme->activate($theme)) {
            return json_encode([
                'status' => 'oke',
            ]);
        }

        return json_encode([
            'status' => 'noke',
        ]);
    }

    /**
     * @return bool
     */
    public function current()
    {
        return $this->theme->current();
    }
}
