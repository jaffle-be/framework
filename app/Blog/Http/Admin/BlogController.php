<?php namespace App\Blog\Http\Admin;

use App\Blog\Jobs\UpdatePost;
use App\Blog\Post;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function index(Request $request)
    {
        $query = Post::with(['translations', 'tags', 'images', 'images.sizes' => function ($query) {
            $query->dimension(150);
        }, 'images.translations']);

        $value = $request->get('query');
        $locale = $request->get('locale');

        $query->whereHas('translations', function ($q) use ($value, $locale) {
            if ($value) {
                $q->where('locale', $locale);
                $q->where(function ($q) use ($value) {
                    $q->where('title', 'like', '%' . $value . '%')
                        ->orWhere('extract', 'like', '%' . $value . '%')
                        ->orWhere('content', 'like', '%' . $value . '%');
                });
            }
        });

        return $query->paginate();
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

        $payload = [
            'post'  => $post,
            'input' => translation_input($request, ['title', 'extract', 'content', 'published_at'])
        ];

        if (!$this->dispatchFromArray(UpdatePost::class, $payload)) {
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