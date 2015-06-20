<?php namespace App\Blog\Http\Admin;

use App\Blog\Post;
use App\Http\Controllers\Controller;
use App\Media\Commands\UpdateImage;
use App\Media\Commands\UploadNewImage;
use App\Media\Image;
use App\Tags\Tag;
use Illuminate\Http\Request;

class BlogTagController extends Controller
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
//        if ($post) {
//
//            $file = $request->file('file');
//
//            $image = $this->dispatchFromArray(UploadNewImage::class, [
//                'owner' => $post,
//                'image' => $file,
//                'sizes' => config('blog.image_sizes')
//            ]);
//
//            $image->load($this->relations());
//
//            return $image;
//        }
    }

    public function update(Post $post, Image $image, Request $request)
    {
//        $image->load($this->relations());
//
//        if ($image->owner->id == $post->id) {
//
//            $input = $request->except(['_token']);
//
//            return $this->dispatchFromArray(UpdateImage::class, [
//                'image' => $image,
//                'input' => $input
//            ]);
//        }
    }

    public function destroy(Post $post, Tag $tag)
    {
        $post->tags()->detach($tag->id);

        if($tag->posts()->count() == 0)
        {
            $tag->delete();
        }
    }
}