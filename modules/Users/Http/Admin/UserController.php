<?php

namespace Modules\Users\Http\Admin;

use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Modules\Media\MediaWidgetPreperations;
use Modules\System\Http\AdminController;
use Modules\Users\Jobs\CheckGravatarImage;

/**
 * Class UserController
 * @package Modules\Users\Http\Admin
 */
class UserController extends AdminController
{
    use MediaWidgetPreperations;

    /**
     * the actual page.
     *
     * @param Guard $guard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile(Guard $guard)
    {
        return view('users::admin.profile');
    }

    /**
     * @param Guard $guard
     * @return mixed
     */
    public function index(Guard $guard)
    {
        $user = $guard->user();

        if ($user->images->count() == 0) {
            $this->dispatch(new CheckGravatarImage($user));
        }

        $user->load(['translations', 'skills', 'skills.translations']);

        $this->prepareImages($user);

        return $user;
    }

    /**
     * @param Request $request
     * @param Guard $guard
     * @return string
     */
    public function store(Request $request, Guard $guard)
    {
        $this->validate($request, ['vat' => 'vat', 'website' => 'url']);

        $data = translation_input($request, ['bio', 'quote', 'quote_author']);

        $user = $guard->user();

        $user->fill($data);

        if ($user->save()) {
            return json_encode([
                'status' => 'oke',
            ]);
        }

        return json_encode([
            'status' => 'noke',
        ]);
    }
}
