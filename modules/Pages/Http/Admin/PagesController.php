<?php

namespace Modules\Pages\Http\Admin;

use Exception;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Modules\Account\AccountManager;
use Modules\Media\MediaWidgetPreperations;
use Modules\Pages\Jobs\UpdatePage;
use Modules\Pages\Page;
use Modules\Pages\PageRepositoryInterface;
use Modules\System\Http\AdminController;

/**
 * Class PagesController
 * @package Modules\Pages\Http\Admin
 */
class PagesController extends AdminController
{
    use MediaWidgetPreperations;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function overview()
    {
        return view('pages::admin.overview');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail()
    {
        return view('pages::admin.detail');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Request $request)
    {
        $query = Page::with([
            'translations',
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
     * @param Page $page
     * @param Guard $guard
     * @param AccountManager $accounts
     * @return Page|string|static
     */
    public function store(Request $request, Page $page, Guard $guard, AccountManager $accounts)
    {
        $input = translation_input($request);

        $page = $page->newInstance($input);

        $page->account_id = $accounts->account()->id;

        $page->user()->associate($guard->user());

        if ($page->save()) {
            return $page;
        }

        return json_encode([
            'status' => 'noke',
        ]);
    }

    /**
     * @param Page $page
     * @param PageRepositoryInterface $pages
     * @return Page
     */
    public function show(Page $page, PageRepositoryInterface $pages)
    {
        $page->load($this->relations());

        //make sure one cannot select itself as a subpage
        $but = new Collection([$page]);

        if ($page->parent) {
            $but->push($page->parent);
        }

        //make sure one cannot select a page B to add as a subpage to page A when page A is already a child of page B
        $availablePages = $pages->with(['translations'])->orphans()->but($but)->get();

        $page->availablePages = $availablePages;

        $this->prepareMedia($page, ['images', 'videos', 'infographics', 'files']);

        return $page;
    }

    /**
     * @param Page $page
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Page|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Page $page, Request $request)
    {
        $page->load($this->relations());

        if (! $this->dispatch(new UpdatePage($page, translation_input($request, ['title', 'content', 'publish_at'])))) {
            return response('500', 'something bad happened');
        }

        $page->load($this->relations());

        return $page;
    }

    /**
     * @param Request $request
     * @param Page $page
     */
    public function batchDestroy(Request $request, Page $page)
    {
        $ids = $request->get('pages', []);

        if (is_array($ids) && count($ids)) {
            $pages = $page->whereIn('pages.id', $ids)
                ->get();

            foreach ($pages as $page) {
                $page->delete();
            }
        }
    }

    /**
     * @param Page $page
     * @return Page
     * @throws Exception
     */
    public function destroy(Page $page)
    {
        //make sure to load the relations, in order to delete morphing relations.
        if ($page->delete()) {
            $page->id = false;
        }

        return $page;
    }

    /**
     * @param Request $request
     * @param Page $page
     */
    public function linkSubpage(Request $request, Page $page)
    {
        $parent = $page->findOrFail($request->get('parent'));

        $page = $page->findOrFail($request->get('page'));

        if (! $page->parent_id) {
            $count = $parent->children()->count();

            $page->sort = $count;

            $parent->children()->save($page);
        }
    }

    /**
     * @param Request $request
     * @param Page $page
     */
    public function unlinkSubpage(Request $request, Page $page)
    {
        $parent = $page->findOrFail($request->get('parent'));

        $page = $page->findOrFail($request->get('page'));

        if ($page->parent_id == $parent->id) {
            $page->parent_id = null;
            $page->save();
        }
    }

    /**
     * @param Request $request
     * @param Page $page
     * @throws Exception
     */
    public function sortSubpages(Request $request, Page $page)
    {
        $parent = $request->get('page');

        $parent = $page->findOrFail($parent);

        $children = $page->where('parent_id', $parent->id)
            ->whereIn('id', $request->get('order'))
            ->get();

        foreach ($request->get('order') as $position => $id) {
            $child = $children->find($id);

            if (! $child) {
                throw new Exception('trying to sort a page not belonging to this parent');
            }

            $child->sort = $position;
            $child->save();
        }
    }

    /**
     * @param Request $request
     * @param Page $page
     */
    public function batchPublish(Request $request, Page $page)
    {
        $ids = $request->get('pages', []);

        if (is_array($ids) && count($ids)) {
            $pages = $page->whereIn('pages.id', $ids)
                ->get();

            foreach ($pages as $page) {
                $translation = $page->translate($request->get('locale'));

                if ($translation) {
                    $translation->published = true;
                }

                $translation->save();
            }
        }
    }

    /**
     * @param Request $request
     * @param Page $page
     */
    public function batchUnpublish(Request $request, Page $page)
    {
        $ids = $request->get('pages', []);

        if (is_array($ids) && count($ids)) {
            $pages = $page->whereIn('pages.id', $ids)
                ->get();

            foreach ($pages as $page) {
                $translation = $page->translate($request->get('locale'));

                if ($translation) {
                    $translation->published = false;
                }

                $translation->save();
            }
        }
    }

    /**
     * @return array
     */
    protected function relations()
    {
        return ['translations', 'translations.slug', 'children', 'children.translations'];
    }
}
