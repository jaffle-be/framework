<?php namespace Modules\Media\Http\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Modules\Media\Commands\UpdateImage;
use Modules\Media\Commands\UploadNewImage;
use Modules\Media\Image;
use Modules\Media\MediaRepositoryInterface;
use Modules\Media\StoresMedia;
use Modules\System\Http\AdminController;
use Modules\Theme\ThemeManager;

class ImageController extends AdminController
{

    /**
     * @var MediaRepositoryInterface
     */
    protected $media;

    /**
     * @param ThemeManager             $theme
     * @param MediaRepositoryInterface $media
     */
    public function __construct(ThemeManager $theme, MediaRepositoryInterface $media)
    {
        $this->media = $media;

        parent::__construct($theme);
    }

    public function widget()
    {
        return view('media::admin.image');
    }

    public function index(Request $request)
    {
        $owner = $this->owner($request);

        $images = $owner->images;

        if($images)
        {
            $images->load($this->relations());

            if(!$owner->mediaStoresMultiple())
            {
                $images = new Collection([$images]);
            }
        }

        return $images;
    }

    protected function relations()
    {
        return [
            'translations',
            'sizes' => function ($query){
                $query->dimension(512);
            }
        ];
    }

    public function store(Request $request)
    {
        $owner = $this->owner($request);

        $file = $request->file('file');

        $image = $this->dispatchFromArray(UploadNewImage::class, [
            'owner' => $owner,
            'image' => $file,
        ]);

        $image->load($this->relations());

        return $image;
    }

    public function update(Image $image, Request $request)
    {
        $image->load($this->relations());

        $owner = $this->owner($request);

        if ($image->owner->id == $owner->id) {

            $input = translation_input($request, ['_token', 'title']);

            return $this->dispatchFromArray(UpdateImage::class, [
                'image' => $image,
                'input' => $input
            ]);
        }
    }

    public function destroy(Request $request, Image $image)
    {
        $image->load('owner');

        $owner = $this->owner($request);

        if ($image->owner->id == $owner->id) {
            $image->delete();
        }
    }

    public function sort(Request $request)
    {
        $owner = $this->owner($request);

        $owner->load('images');

        foreach($request->get('order') as $position => $id)
        {
            $image = $owner->images->find($id);
            $image->sort = $position;
            $image->save();
        }
    }

    /**
     * @param Request $request
     *
     * @return StoresMedia
     */
    protected function owner(Request $request)
    {
        return $this->media->findOwner($request->get('ownerType'), $request->get('ownerId'));
    }

}