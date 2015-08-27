<?php namespace App\Search\Http;

use App\Blog\Post;
use App\Search\SearchServiceInterface;
use App\System\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SearchController extends Controller
{

    public function index(Request $request, Post $post, SearchServiceInterface $search)
    {
        $locale = app()->getLocale();

        if($request->get('query'))
        {
            $posts = $search->search('posts', [
                'index' => 'framework',
                'type'  => 'posts',
                'body'  => [
                    "query" => [
                        "filtered" => [
                            "query" => [
                                "nested" => [
                                    "path"  => "translations.$locale",
                                    "query" => [
                                        "multi_match" => [
                                            "query"  => $request->get('query'),
                                            "fields" => ["translations.$locale.title", "translations.$locale.extract", "translations.$locale.content"]
                                        ]
                                    ]
                                ]
                            ],
                            "filter" => [
                                "nested" => [
                                    "path" => "translations.$locale",
                                    "filter" => [
                                        "bool" => [
                                            "must" => [
                                                "range" => [
                                                    "translations.$locale.publish_at" => ['lte' => 'now']
                                                ]
                                            ]
                                        ]
                                    ]
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
                                    "query"  => $request->get('query'),
                                    "fields" => ["translations.$locale.title", "translations.$locale.description"]

                                ]
                            ]
                        ]
                    ]
                ]
            ], ['images'], false);
        }

        else{
            $posts = new Collection();
            $projects = new Collection();
        }

        return $this->theme->render('search.index', ['posts' => $posts, 'projects' => $projects]);
    }
}