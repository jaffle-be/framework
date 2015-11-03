<?php namespace Modules\Media\Http\Admin;

use Illuminate\Http\Request;
use Modules\Media\Commands\UploadNewInfographic;
use Modules\Media\Infographics\Infographic;
use Modules\Media\MediaRepositoryInterface;
use Modules\Media\MediaWidgetPreperations;
use Modules\System\Http\AdminController;
use Modules\System\Locale;
use Modules\Theme\ThemeManager;

class InfographicController extends AdminController
{
    use MediaWidgetPreperations;

    protected $media;

    public function __construct(ThemeManager $theme, MediaRepositoryInterface $media)
    {
        $this->media = $media;

        parent::__construct($theme);
    }

    public function widget()
    {
        return view('media::admin.infographic');
    }

    public function index(Request $request, Locale $locale)
    {
        $owner = $this->owner($request);

        $this->prepareInfographics($owner);

        return $owner->infographics;
    }

    public function store(Request $request, Locale $locale)
    {
        $owner = $this->owner($request);

        $file = $request->file('file');

        $infographic = $this->dispatchFromArray(UploadNewInfographic::class, [
            'owner' => $owner,
            'graphic' => $file,
            'locale' => $locale->whereSlug($request->get('locale'))->firstOrFail(),
        ]);

        $infographic->load('sizes');

        return $infographic;
    }

    public function update(Infographic $infographic, Request $request)
    {
        $owner = $this->owner($request);

        if ($infographic->owner->id == $owner->id) {

            $input = $request->except('_token');

            $infographic->fill($input);

            $infographic->save();
        }
    }

    public function destroy(Infographic $infographic, Request $request)
    {
        $infographic->load('owner');

        $owner = $this->owner($request);

        if ($infographic->owner->id == $owner->id) {
            $infographic->delete();
        }
    }

    public function sort(Request $request, Locale $locale)
    {
        $owner = $this->owner($request);

        $owner->load('infographics');

        foreach ($request->get('order') as $position => $id) {
            $infographic = $owner->infographics->find($id);
            $infographic->sort = $position;
            $infographic->save();
        }
    }



}