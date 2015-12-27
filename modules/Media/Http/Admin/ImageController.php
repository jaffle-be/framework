<?php

namespace Modules\Media\Http\Admin;

use Illuminate\Http\Request;
use Modules\Media\Commands\UpdateImage;
use Modules\Media\Commands\UploadNewImage;
use Modules\Media\Image;
use Modules\Media\MediaRepositoryInterface;
use Modules\Media\MediaWidgetPreperations;
use Modules\System\Http\AdminController;
use Modules\Theme\ThemeManager;

/**
 * Class ImageController
 * @package Modules\Media\Http\Admin
 */
class ImageController extends AdminController
{
    use MediaWidgetPreperations;

    /**
     * @var MediaRepositoryInterface
     */
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
        return view('media::admin.image');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $owner = $this->owner($request);

        $this->prepareImages($owner);

        return $owner->images;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $owner = $this->owner($request);

        $file = $request->file('file');

        $image = $this->dispatch(new UploadNewImage($owner, $file));

        $image->load($this->mediaImageRelations());

        return $image;
    }

    /**
     * @param Image $image
     * @param Request $request
     * @return mixed
     */
    public function update(Image $image, Request $request)
    {
        $image->load($this->mediaImageRelations());

        $owner = $this->owner($request);

        if ($image->owner->id == $owner->id) {
            $input = translation_input($request, ['_token', 'title']);

            return $this->dispatch(new UpdateImage($image, $input));
        }
    }

    /**
     * @param Request $request
     * @param Image $image
     * @throws \Exception
     */
    public function destroy(Request $request, Image $image)
    {
        $image->load('owner');

        $owner = $this->owner($request);

        if ($image->owner->id == $owner->id) {
            $image->delete();
        }
    }

    /**
     * @param Request $request
     */
    public function sort(Request $request)
    {
        $owner = $this->owner($request);

        $owner->load('images');

        foreach ($request->get('order') as $position => $id) {
            $image = $owner->images->find($id);
            $image->sort = $position;
            $image->save();
        }
    }
}
