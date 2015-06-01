<?php namespace App\Blog\Http\Admin;

use App\Blog\Post;
use App\Http\Controllers\Controller;
use App\Media\Commands\UploadNewImage;
use App\Media\Image;
use Illuminate\Http\Request;

class BlogImageController extends Controller
{

    public function store(Post $post, Request $request)
    {
        if ($post) {

            $file = $request->file('file');

            $image = $this->dispatchFromArray(UploadNewImage::class, [
                'owner' => $post,
                'image' => $file,
                'sizes' => config('blog.image_sizes')
            ]);

            $image->load([
                'sizes' => function ($query) {
                    $query->dimension(340);
                },
                'translations'
            ]);

            return $image;
        }
    }

    public function update(Image $image, Post $post)
    {
        if ($image->owner->id == $post->id) {
            //update image
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