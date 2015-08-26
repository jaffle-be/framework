<?php namespace App\Search\Http;

use App\Blog\Post;
use App\Search\SearchServiceInterface;
use App\System\Http\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function index(Request $request, Post $post, SearchServiceInterface $search)
    {
        dd('still need to make sure documents returned are published ones');
        
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
                                "fields" => ["translations.$locale.title", "translations.$locale.extract", "translations.$locale.content"]
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
                            "multi_match" => [
                                "query" => $request->get('query'),
                                "fields" => ["translations.$locale.title", "translations.$locale.description"]

                            ]
                        ]
                    ]
                ]
            ]
        ], ['images'], false);

        return $this->theme->render('search.index', ['posts' => $posts, 'projects' => $projects]);
    }
}