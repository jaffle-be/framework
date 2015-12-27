<?php

namespace Modules\System\Http\Admin;

use Illuminate\Http\Request;
use Modules\System\Http\AdminController;
use Modules\System\Locale;
use Modules\System\Seo\SeoProperty;
use Modules\Theme\ThemeManager;

class SeoController extends AdminController
{

    public function __construct(ThemeManager $theme)
    {
        parent::__construct($theme);
    }

    public function widget()
    {
        return view('system::admin.seo');
    }

    public function index(Request $request)
    {
        return $this->owner($request)->seo;
    }

    public function store(Request $request, Locale $locale)
    {
        $owner = $this->owner($request);

        $locale = $locale->whereSlug($request->get('locale'))->first();

        if (!$locale) {
            return;
        }

        $seo = $owner->seo->first(function ($key, $item) use ($locale) {
            return $item->locale_id == $locale->id;
        });

        if ($seo) {
            if ($this->hasData($request)) {
                $seo->title = $request->get('title');
                $seo->description = $request->get('description');
                $seo->keywords = $request->get('keywords');
                $seo->save();
            } else {
                $seo->delete();
            }
        } else {
            if ($this->hasData($request)) {
                $seo = new SeoProperty([
                    'locale_id' => $locale->id,
                    'title' => $request->get('title'),
                    'description' => $request->get('description'),
                    'keywords' => $request->get('keywords'),
                ]);

                $owner->seo()->save($seo);
            }
        }
    }

    protected function hasData(Request $request)
    {
        foreach (['title', 'description', 'keywords'] as $key) {
            if ($request->has($key) && $request->get($key)) {
                return true;
            }
        }

        return false;
    }

    protected function owner(Request $request)
    {
        $ownerType = $request->get('ownerType');
        $ownerId = $request->get('ownerId');

        $owners = config('system.seo.owners');

        if (!isset($owners[$ownerType])) {
            throw new \Exception('Invalid owner type provided for seo');
        }

        $finder = new $owners[$ownerType]();

        return $finder->findOrFail($ownerId);
    }
}
