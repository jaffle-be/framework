<?php namespace App\Blog\Http\Admin;

use App\Blog\Post;
use App\Http\Controllers\Controller;
use App\Tags\Commands\CreateNewTag;
use App\Tags\Commands\TagSomething;
use App\Tags\Commands\UntagSomething;
use App\Tags\Commands\UpdateTag;
use App\Tags\Tag;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

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

    public function index(Post $post, Tag $tag, Request $request)
    {
        $value = $request->get('value');

        $locale = $request->get('locale');

        $tags = $post->tags->lists('id');

        $tags = $tag
            ->with(['translations'])
            ->where(function ($q) use ($tags) {
                if (!empty($tags)) {
                    $q->whereNotIn('id', $tags);
                }
            })
            ->whereHas('translations', function ($q) use ($value, $locale) {
                $q->where('locale', $locale);
                $q->where('name', 'like', '%' . $value . '%');
            })
            ->paginate(10);

        $sorted = new Collection($tags->items());

        $sorted->sortBy(function($tag) use ($locale){
            return $tag->translate($locale)->name;
        });

        $tags = new Paginator($sorted, $tags->perPage(), $tags->currentPage());

        return $tags;
    }

    public function store(Post $post, Request $request)
    {
        $name = $request->get('name');
        $locale = $request->get('locale');

        if ($post) {

            $tag = $this->dispatchFromArray(CreateNewTag::class, [
                $locale => [
                    'name' => $name
                ]
            ]);

            if ($tag) {
                $this->dispatchFromArray(TagSomething::class, [
                    'owner' => $post,
                    'tag'   => $tag
                ]);
            }
        }
    }

    public function update(Post $post, Tag $tag, Request $request)
    {
        //if the post didn't contain the tag, we wanted to add it.
        if (!$post->tags->contains($tag->id)) {

            $this->dispatchFromArray(TagSomething::class, [
                'owner' => $post,
                'tag'   => $tag
            ]);
        }

        $this->dispatchFromArray(UpdateTag::class, [
            'tag'   => $tag,
            'input' => $request->all()
        ]);
    }

    public function destroy(Post $post, Tag $tag)
    {
        return $this->dispatchFromArray(UntagSomething::class, [
            'owner' => $post,
            'tag'   => $tag
        ]);
    }
}