<?php namespace App\Blog\Http\Admin;

use App\Blog\Post;
use App\Http\Controllers\Controller;
use App\Media\Commands\UploadNewImage;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function index(Request $request)
    {
        return \App\Blog\Post::with(['translations'])->paginate();
    }

    public function store(Request $request, Post $post, Guard $guard)
    {
        $input = $this->input($request);

        $post = $post->newInstance($input);

        $post->user()->associate($guard->user());

        if ($post->save()) {
            return $post;
        }

        return json_encode(array(
            'status' => 'noke'
        ));
    }

    public function show($id)
    {
        return \App\Blog\Post::with(['translations'])->find($id);
    }

    public function update($id, Request $request)
    {
        $post = \App\Blog\Post::with(['translations'])->find($id);

        $input = $this->input($request);

        $post->fill($input);

        if (!$post->save()) {
            return response('500', 'something bad happened');
        }

        return $post;
    }

    public function upload($id, Request $request)
    {
        $post = $post = Post::find($id);

        if ($post) {

            $file = $request->file('file');

            $this->dispatchFromArray(UploadNewImage::class, [
                'owner' => $post,
                'image' => $file,
                'sizes' => config('blog.image_sizes')
            ]);
        }
    }

    public function overview()
    {
        return view('blog::admin.overview');
    }

    public function detail()
    {
        return view('blog::admin.detail');
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    protected function input(Request $request)
    {
        $input = $request->all();

        foreach ($input['translations'] as $locale => $translation) {
            $input[$locale] = $translation;
        }

        return $input;
    }
}