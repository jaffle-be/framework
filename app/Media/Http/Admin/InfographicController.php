<?php namespace App\Media\Http\Admin;

use App\Media\Commands\UploadNewInfographic;
use App\Media\Infographics\Infographic;
use App\Media\MediaRepositoryInterface;
use App\System\Http\AdminController;
use App\System\Locale;
use App\Theme\ThemeManager;
use Illuminate\Http\Request;

class InfographicController extends AdminController
{
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

        $infographics = $owner->infographics;

        $infographics->load('sizes');

        return $infographics->byLocale();
    }

    protected function owner(Request $request)
    {
        $id = $request->get('ownerId');
        $type = $request->get('ownerType');

        return $this->media->findOwner($type, $id);
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