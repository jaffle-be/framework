<?php namespace App\Http\Controllers;

use App\Media\Media;
use Illuminate\Foundation\Bus\DispatchesCommands;
use App\Media\Commands\StoreNewImage;

class WelcomeController extends Controller
{

    use DispatchesCommands;

    public function appHome()
    {
        return view('home.app');
    }

    public function storeHome()
    {
        return view('home.store');
    }

    public function appDash()
    {
        return view('layouts.back');
    }

    public function storeDash()
    {
        return view('layouts.back');
    }

    public function test()
    {
        foreach (\App\Shop\Product\Product::all() as $product) {

            $this->dispatchFromArray(StoreNewImage::class, [
                'owner' => $product,
                'path'  => public_path(sprintf('assets/img/team/img-v%d.jpg', rand(1, 3))),
                'sizes' => [
                    '400x300',
                    '800x600'
                ]
            ]);
        }

        return redirect('/test2');
    }

    public function test2()
    {
        $image = \App\Media\Image::first();

        return sprintf('<img src="%s"><a href="test">click</a>', $image ? $image->path : null);
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
}
