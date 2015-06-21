<?php namespace App\Blog\Http\Admin;

use App\Blog\Post;
use App\Http\Controllers\Controller;
use App\Media\Commands\UpdateImage;
use App\Media\Commands\UploadNewImage;
use App\Media\Image;
use Illuminate\Http\Request;

class BlogImageController extends Controller
{

    protected function relations()
    {
        return [
            'sizes' => function ($query) {
                $query->dimension(340);
            },
            'translations'
        ];
    }

    public function store(Post $post, Request $request)
    {
        if ($post) {

            $file = $request->file('file');

            $image = $this->dispatchFromArray(UploadNewImage::class, [
                'owner' => $post,
                'image' => $file,
                'sizes' => config('blog.image_sizes')
            ]);

            $image->load($this->relations());

            return $image;
        }
    }

    public function update(Post $post, Image $image, Request $request)
    {
        $image->load($this->relations());

        if ($image->owner->id == $post->id) {

            $input = $request->except(['_token', 'title']);

            return $this->dispatchFromArray(UpdateImage::class, [
                'image' => $image,
                'input' => $input
            ]);
        }
    }

    public function destroy(Post $post, Image $image)
    {
        $image->load('owner');

        if ($image->owner->id == $post->id) {
            $image->delete();
        }
    }
}