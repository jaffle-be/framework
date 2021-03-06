<?php

namespace Modules\Search\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Modules\Account\AccountManager;
use Modules\Blog\BlogSearch;
use Modules\Blog\Post;
use Modules\Portfolio\PortfolioSearch;
use Modules\Search\SearchServiceInterface;
use Modules\System\Http\FrontController;

/**
 * Class SearchController
 * @package Modules\Search\Http
 */
class SearchController extends FrontController
{
    use BlogSearch;
    use PortfolioSearch;

    /**
     * @param Request $request
     * @param Post $post
     * @param SearchServiceInterface $search
     * @param AccountManager $account
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request, Post $post, SearchServiceInterface $search, AccountManager $account)
    {
        $locale = app()->getLocale();

        if ($request->get('query')) {
            $posts = $search->search('posts', $this->postsQuery($request, $account, $locale), ['images'], false);

            $projects = $search->search('projects', $this->projectsQuery($request, $account, $locale), ['images'], false);
        } else {
            $posts = new Collection();
            $projects = new Collection();
        }

        return $this->theme->render('search.index', ['posts' => $posts, 'projects' => $projects]);
    }
}
