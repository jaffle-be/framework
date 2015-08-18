<?php namespace App\Search\Http;

use App\Blog\Post;
use App\Search\SearchServiceInterface;
use App\System\Http\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function index(Request $request, Post $post, SearchServiceInterface $search)
    {
        $locale = app()->getLocale();

        $posts = $search->search('posts', [
            'index' => 'framework',
            'type'  => 'posts',
            'body'  => [
                "query" => [
                    "nested" => [
                        "path"  => "translations.en",
                        "query" => [
                            "multi_match" => [
                                "query"  => $request->get('query'),
                                "fields" => ["translations.en.title", "translations.en.extract", "translations.en.content"]
                            ]
                        ]
                    ]
                ]
            ]
        ], ['images'], false);

        $projects = $search->search('projects', [
            'index' => 'framework',
            'type'  => 'projects',
            'body'  => [
                "query" => [
                    "nested" => [
                        "path"  => "translations." . $locale,
                        "query" => [
                            "match" => [
                                "translations." . $locale . ".title" => $request->get('query')
                            ]
                        ]
                    ]
                ]
            ]
        ], ['images'], false);

        return $this->theme->render('search.index', ['posts' => $posts, 'projects' => $projects]);
    }

    /**
     * @return array
     */
    protected function localizedColumns()
    {
        $locale = app()->getLocale();

        $columns = [
            'translations.' . $locale . '.title',
            'translations.' . $locale . '.extract',
            'translations.' . $locale . '.content',
        ];

//        return ['title', 'extract', 'content'];

        return $columns;
    }

}