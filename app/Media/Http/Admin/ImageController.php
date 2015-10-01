<?php namespace App\Media\Http\Admin;

use App\Media\Commands\UpdateImage;
use App\Media\Commands\UploadNewImage;
use App\Media\Image;
use App\System\Http\AdminController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ImageController extends AdminController
{

    public function widget()
    {
        return view('media::admin.images.widget');
    }

    public function index(Request $request)
    {
        $owner = $this->owner($request);
        
        $images = $owner->images;

        if($images)
        {
            $images->load($this->relations());

            if(!$images instanceof Collection)
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

    protected function sizes(Request $request)
    {
        $type = $request->get('ownerType');

        $sizes = config('media.sizes');

        if (!isset($sizes[$type])) {
            throw new \Exception('No valid sizes for this media type defined');
        }

        return $sizes[$type];
    }

    protected function owner(Request $request)
    {
        $id = $request->get('ownerId');
        $type = $request->get('ownerType');

        $owners = config('media.owners');

        if (!isset($owners[$type])) {
            throw new Exception('Invalid owner type provided for images');
        }

        $class = $owners[$type];

        $class = new $class();

        return $class->findOrFail($id);
    }

    public function store(Request $request)
    {
        $owner = $this->owner($request);

        $sizes = $this->sizes($request);

        $file = $request->file('file');

        $image = $this->dispatchFromArray(UploadNewImage::class, [
            'owner' => $owner,
            'image' => $file,
            'sizes' => $sizes,
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

}