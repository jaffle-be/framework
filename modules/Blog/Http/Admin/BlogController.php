<?php

namespace Modules\Blog\Http\Admin;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Modules\Account\AccountManager;
use Modules\Blog\Jobs\UpdatePost;
use Modules\Blog\Post;
use Modules\Media\MediaWidgetPreperations;
use Modules\System\Http\AdminController;

/**
 * Class BlogController
 * @package Modules\Blog\Http\Admin
 */
class BlogController extends AdminController
{
    use MediaWidgetPreperations;

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Request $request)
    {
        $query = Post::with([
            'translations',
            'tags',
            'images',
            'images.sizes' => function ($query) {
                $query->dimension(150);
            },
            'images.translations',
        ]);

        $value = $request->get('query');
        $locale = $request->get('locale');

        if (! empty($value)) {
            $query->whereHas('translations', function ($q) use ($value, $locale) {
                $q->where('locale', $locale);
                $q->where(function ($q) use ($value) {
                    $q->where('title', 'like', '%'.$value.'%')
                        ->orWhere('content', 'like', '%'.$value.'%');
                });
            });
        }

        return $query->paginate();
    }

    /**
     * @param Request $request
     * @param Post $post
     * @param Guard $guard
     * @param AccountManager $accounts
     * @return Post|string|static
     */
    public function store(Request $request, Post $post, Guard $guard, AccountManager $accounts)
    {
        $input = translation_input($request);

        $post = $post->newInstance($input);

        $post->account_id = $accounts->account()->id;

        $post->user()->associate($guard->user());

        if ($post->save()) {
            return $post;
        }

        return json_encode([
            'status' => 'noke',
        ]);
    }

    /**
     * @param Post $post
     * @return Post
     */
    public function show(Post $post)
    {
        $post->load($this->relations());

        $this->prepareMedia($post, ['images', 'infographics', 'videos', 'files']);

        return $post;
    }

    /**
     * @param Post $post
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Post|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Post $post, Request $request)
    {
        $post->load($this->relations());

        $input = translation_input($request, ['title', 'content', 'publish_at']);

        if (! $this->dispatch(new UpdatePost($post, $input))) {
            return response('500', 'something bad happened');
        }

        return $post;
    }

    /**
     * @param Post $post
     * @return Post
     * @throws \Exception
     */
    public function destroy(Post $post)
    {
        if ($post->delete()) {
            $post->id = false;
        }

        return $post;
    }

    /**
     * @param Request $request
     * @param Post $post
     */
    public function batchDestroy(Request $request, Post $post)
    {
        $ids = $request->get('posts', []);

        if (is_array($ids) && count($ids)) {
            $posts = $post->whereIn('posts.id', $ids)
                ->get();

            foreach ($posts as $post) {
                $post->delete();
            }
        }
    }

    /**
     * @param Request $request
     * @param Post $post
     */
    public function batchPublish(Request $request, Post $post)
    {
        $ids = $request->get('posts', []);

        if (is_array($ids) && count($ids)) {
            $posts = $post->whereIn('posts.id', $ids)
                ->get();

            foreach ($posts as $post) {
                $translation = $post->translate($request->get('locale'));

                if ($translation) {
                    $translation->publish_at = new Carbon();
                }

                $translation->save();
            }
        }
    }

    /**
     * @param Request $request
     * @param Post $post
     */
    public function batchUnpublish(Request $request, Post $post)
    {
        $ids = $request->get('posts', []);

        if (is_array($ids) && count($ids)) {
            $posts = $post->whereIn('posts.id', $ids)
                ->get();

            foreach ($posts as $post) {
                $translation = $post->translate($request->get('locale'));

                if ($translation) {
                    $translation->publish_at = null;
                }

                $translation->save();
            }
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function overview()
    {
        return view('blog::admin.overview');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail()
    {
        return view('blog::admin.detail');
    }

    /**
     * @return array
     */
    protected function relations()
    {
        return ['translations', 'translations.slug'];
    }
}
