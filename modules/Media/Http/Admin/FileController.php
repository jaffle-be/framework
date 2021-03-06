<?php

namespace Modules\Media\Http\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Media\Commands\UploadNewFile;
use Modules\Media\Files\File;
use Modules\Media\MediaRepositoryInterface;
use Modules\Media\MediaWidgetPreperations;
use Modules\System\Http\AdminController;
use Modules\System\Locale;
use Modules\Theme\ThemeManager;

/**
 * Class FileController
 * @package Modules\Media\Http\Admin
 */
class FileController extends AdminController
{
    use MediaWidgetPreperations;

    protected $media;

    /**
     * @param ThemeManager $theme
     * @param MediaRepositoryInterface $media
     */
    public function __construct(ThemeManager $theme, MediaRepositoryInterface $media)
    {
        $this->media = $media;

        parent::__construct($theme);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function widget()
    {
        return view('media::admin.file');
    }

    /**
     * @param Request $request
     * @param Locale $locale
     * @return
     */
    public function index(Request $request, Locale $locale)
    {
        $owner = $this->owner($request);

        return $owner->files;
    }

    /**
     * @param Request $request
     * @param Locale $locale
     * @return array|JsonResponse|mixed|null|\Symfony\Component\HttpFoundation\File\UploadedFile
     */
    public function store(Request $request, Locale $locale)
    {
        $owner = $this->owner($request);

        $file = $request->file('file');

        $file = $this->dispatch(new UploadNewFile($owner, $file, $locale->whereSlug($request->get('locale'))->firstOrFail()));

        if (! $file) {
            return new JsonResponse('Something went wrong, check for duplicate filename', 400);
        }

        return $file;
    }

    /**
     * @param File $file
     * @param Request $request
     */
    public function update(File $file, Request $request)
    {
        $owner = $this->owner($request);

        if ($file->owner->id == $owner->id) {
            $input = $request->except(['_token']);

            $file->fill($input);

            $file->save();
        }
    }

    /**
     * @param Request $request
     * @param File $file
     * @throws \Exception
     */
    public function destroy(Request $request, File $file)
    {
        $file->load('owner');

        $owner = $this->owner($request);

        if ($file->owner->id == $owner->id) {
            $file->delete();
        }
    }

    /**
     * @param Request $request
     */
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
