<?php namespace App\Pages\Http\Admin;

use App\Account\AccountManager;
use App\Pages\Jobs\UpdatePage;
use App\Pages\Page;
use App\System\Http\AdminController;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class PagesController extends AdminController
{

    public function overview()
    {
        return view('pages::admin.overview');
    }

    public function detail()
    {
        return view('pages::admin.detail');
    }

    public function index(Request $request)
    {
        $query = Page::with(['translations', 'images', 'images.sizes' => function ($query) {
            $query->dimension(150);
        }, 'images.translations']);

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

    public function store(Request $request, Page $page, Guard $guard, AccountManager $accounts)
    {
        $input = translation_input($request);

        $page = $page->newInstance($input);

        $page->account_id = $accounts->account()->id;

        $page->user()->associate($guard->user());

        if ($page->save()) {
            return $page;
        }

        return json_encode(array(
            'status' => 'noke'
        ));
    }

    public function show(Page $page)
    {
        $page->load($this->relations());

        return $page;
    }

    public function update(Page $page, Request $request)
    {
        $page->load($this->relations());

        $payload = [
            'page'  => $page,
            'input' => translation_input($request, ['title', 'content', 'publish_at'])
        ];

        if (!$this->dispatchFromArray(UpdatePage::class, $payload)) {
            return response('500', 'something bad happened');
        }

        $page->load($this->relations());

        return $page;
    }

    public function batchDestroy(Request $request, Page $page)
    {
        $ids = $request->get('pages', []);

        if(is_array($ids) && count($ids))
        {
            $pages = $page->whereIn('pages.id', $ids)
                ->get();

            foreach($pages as $page)
            {
                $page->delete();
            }
        }
    }

    public function destroy(Page $page)
    {
        //make sure to load the relations, in order to delete morphing relations.
        if($page->delete())
        {
            $page->id = false;
        }

        return $page;
    }


    protected function relations()
    {
        return ['translations', 'translations.slug'];
    }



}