<?php namespace App\Blog\Http\Admin;

use App\Blog\Post;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function index(Request $request)
    {
        return \App\Blog\Post::with(['translations', 'tags', 'images', 'images.sizes' => function ($query) {
            $query->dimension(150);
        }, 'images.translations'])->paginate();
    }

    public function store(Request $request, Post $post, Guard $guard)
    {
        $input = translation_input($request);

        $post = $post->newInstance($input);

        $post->user()->associate($guard->user());

        if ($post->save()) {
            return $post;
        }

        return json_encode(array(
            'status' => 'noke'
        ));
    }

    public function show(Post $post)
    {
        $post->load($this->relations());

        return $post;
    }

    public function update(Post $post, Request $request)
    {
        $post->load($this->relations());

        $input = translation_input($request);

        $post->fill($input);

        if (!$post->save()) {
            return response('500', 'something bad happened');
        }

        return $post;
    }

    public function overview()
    {
        return view('blog::admin.overview');
    }

    public function detail()
    {
        return view('blog::admin.detail');
    }

    protected function relations()
    {
        return ['translations', 'tags', 'tags.translations', 'images', 'images.sizes' => function ($query) {
            $query->dimension(340);
        }, 'images.translations'];
    }
}