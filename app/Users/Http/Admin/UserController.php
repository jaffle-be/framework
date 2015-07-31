<?php namespace App\Users\Http\Admin;

use App\Http\Controllers\AdminController;
use App\Users\Jobs\CheckGravatarImage;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;

class UserController extends AdminController
{

    /**
     * the actual page
     */
    public function profile(Guard $guard)
    {
        return view('users::admin.profile');
    }

    public function index(Guard $guard)
    {
        $user = $guard->user();

        if($user->images->count() ==0)
        {
            $this->dispatch(new CheckGravatarImage($user));
        }

        return $user;
    }

    public function store(Request $request, Guard $guard)
    {
        $this->validate($request, ['vat' => 'vat', 'website' => 'url']);

        $data = $request->only(['firstname', 'lastname', 'phone', 'vat', 'website']);

        $user = $guard->user();

        $user->fill($data);

        if ($user->save()) {
            return json_encode(array(
                'status' => 'oke'
            ));
        }

        return json_encode(array(
            'status' => 'noke'
        ));
    }

}