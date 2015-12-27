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

class BlogController extends AdminController
{

    use MediaWidgetPreperations;

    public function index(Request $request)
    {
        $query = Post::with([
            'translations',
            'tags',
            'images',
            'images.sizes' => function ($query) {
                $query->dimension(150);
            },
            'images.translations'
        ]);

        $value = $request->get('query');
        $locale = $request->get('locale');

        if (!empty($value)) {
            $query->whereHas('translations', function ($q) use ($value, $locale) {
                $q->where('locale', $locale);
                $q->where(function ($q) use ($value) {
                    $q->where('title', 'like', '%' . $value . '%')
                        ->orWhere('content', 'like', '%' . $value . '%');
                });
            });
        }

        return $query->paginate();
    }

    public function store(Request $request, Post $post, Guard $guard, AccountManager $accounts)
    {
        $input = translation_input($request);

        $post = $post->newInstance($input);

        $post->account_id = $accounts->account()->id;

        $post->user()->associate($guard->user());

        if ($post->save()) {
            return $post;
        }

        return json_encode(array(
            'status' => 'noke',
        ));
    }

    public function show(Post $post)
    {
        $post->load($this->relations());

        $this->prepareMedia($post, ['images', 'infographics', 'videos', 'files']);

        return $post;
    }

    public function update(Post $post, Request $request)
    {
        $post->load($this->relations());

        $input = translation_input($request, ['title', 'content', 'publish_at']);

        if (!$this->dispatch(new UpdatePost($post, $input))) {
            return response('500', 'something bad happened');
        }

        return $post;
    }

    public function destroy(Post $post)
    {
        if ($post->delete()) {
            $post->id = false;
        }

        return $post;
    }

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
        return ['translations', 'translations.slug'];
    }
}
