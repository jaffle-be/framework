<?php

namespace Modules\Tags\Http\Admin;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Modules\System\Http\AdminController;
use Modules\Tags\Commands\CreateNewTag;
use Modules\Tags\Commands\TagSomething;
use Modules\Tags\Commands\UntagSomething;
use Modules\Tags\Commands\UpdateTag;
use Modules\Tags\Tag;

class TagController extends AdminController
{
    public function widget()
    {
        return view('tags::admin.widget');
    }

    public function index(Tag $tag, Request $request)
    {
        $value = $request->get('value');

        $locale = $request->get('locale');

        $owner = $this->owner($request);

        $tags = $owner->tags->lists('id');

        //why o why did we paginate this?
        $tags = $tag
            ->with(['translations'])
            ->where(function ($q) use ($tags) {
                if (! empty($tags)) {
                    $q->whereNotIn('id', $tags);
                }
            })
            ->whereHas('translations', function ($q) use ($value, $locale) {
                $q->where('locale', $locale);
                $q->where('name', 'like', '%'.$value.'%');
            })
            ->paginate(10);

        $sorted = new Collection($tags->items());

        $sorted = $sorted->sortBy(function ($tag) use ($locale) {
            return $tag->translate($locale)->name;
        });

        $tags = new Paginator($sorted, $tags->perPage(), $tags->currentPage());

        return $tags;
    }

    public function store(Request $request)
    {
        $name = $request->get('name');
        $locale = $request->get('locale');

        $owner = $this->owner($request);

        if ($owner) {
            $tag = $this->dispatch(new CreateNewTag($locale, $name));

            if ($tag) {
                $this->dispatch(new TagSomething($tag, $owner));
            }
        }

        return $tag;
    }

    public function update(Tag $tag, Request $request)
    {
        $owner = $this->owner($request);

        $tag->load(['translations']);

        //if the owner didn't contain the tag, we wanted to add it.
        if (! $owner->tags->contains($tag->id)) {
            $this->dispatch(new TagSomething($tag, $owner));
        }

        $this->dispatch(new UpdateTag($tag, translation_input($request, ['name'])));

        return $tag;
    }

    public function destroy(Tag $tag, Request $request)
    {
        $owner = $this->owner($request);

        return $this->dispatch(new UntagSomething($owner, $tag));
    }

    public function all(Request $request)
    {
        $owner = $this->owner($request);

        $owner->load([
            'tags',
            'tags.translations',
        ]);

        return $owner->tags;
    }

    /**
     *
     * @throws \Exception
     */
    protected function owner(Request $request)
    {
        $ownerType = $request->get('ownerType');
        $ownerId = $request->get('ownerId');

        $owners = config('tags.owners');

        if (! isset($owners[$ownerType])) {
            throw new \Exception('Invalid owner type provided for tags');
        }

        $finder = new $owners[$ownerType]();

        return $finder->findOrFail($ownerId);
    }
}
