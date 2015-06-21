<?php namespace App\Blog\Http;

use App\Blog\Post;
use App\Http\Controllers\Controller;

class BlogController extends Controller{

    public function index(Post $post)
    {
        /**
         * the correct template should be fetched from somewhere,
         * however, i'm not to sure where from at this point.
         * change the template name however you need it.
         */

        $posts = Post::with($this->relations(460))->orderBy('created_at', 'desc')->paginate();

        return view('blog::full-width.medium-overview', ['posts' => $posts]);
    }

    public function show(Post $post)
    {
        $post->load($this->relations(1140));

        $related = $post->with($this->relations(360))->get()->shuffle()->take(3);

        return view('blog::full-width.large-detail', ['post' => $post, 'related' => $related]);
    }

    /**
     * @return array
     */
    protected function relations($dimension)
    {
        return ['translations', 'images', 'images.translations', 'images.sizes' => function ($query) use ($dimension) {
            $query->dimension($dimension);
        }];
    }
}