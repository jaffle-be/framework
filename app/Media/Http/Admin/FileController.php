<?php namespace App\Media\Http\Admin;

use App\Media\Commands\UploadNewFile;
use App\Media\Files\File;
use App\Media\MediaRepositoryInterface;
use App\System\Http\AdminController;
use App\System\Locale;
use App\Theme\ThemeManager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FileController extends AdminController
{
    protected $media;

    public function __construct(ThemeManager $theme, MediaRepositoryInterface $media)
    {
        $this->media = $media;

        parent::__construct($theme);
    }

    public function widget()
    {
        return view('media::admin.file');
    }

    /**
     * @param Request $request
     * @param Locale  $locale
     *
     * @return mixed
     */
    public function index(Request $request, Locale $locale)
    {
        $owner = $this->owner($request);

        $files = $owner->files;

        return $files->byLocale();
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

        $file = $this->dispatchFromArray(UploadNewFile::class, [
            'owner' => $owner,
            'file' => $file,
            'locale' => $locale->whereSlug($request->get('locale'))->firstOrFail(),
        ]);

        if(!$file)
        {
            return new JsonResponse('Something went wrong, check for duplicate filename', 400);
        }

        return $file;
    }

    public function update(File $file, Request $request)
    {
        $owner = $this->owner($request);

        if ($file->owner->id == $owner->id) {

            $input = $request->except(['_token']);

            $file->fill($input);

            $file->save();
        }
    }

    public function destroy(Request $request, File $file)
    {
        $file->load('owner');

        $owner = $this->owner($request);

        if ($file->owner->id == $owner->id) {
            $file->delete();
        }
    }

    public function sort(Request $request)
    {
        $owner = $this->owner($request);

        $owner->load('files');

        foreach ($request->get('order') as $position => $id) {
            $file = $owner->files->find($id);
            $file->sort = $position;
            $file->save();
        }
    }


}