<?php namespace App\Search\Http;

use App\Account\AccountManager;
use App\Blog\Post;
use App\Search\SearchServiceInterface;
use App\System\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SearchController extends Controller
{

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

    /**
     * @param Request $request
     * @param         $locale
     *
     * @return array
     */
    protected function postsQuery(Request $request, AccountManager $manager, $locale)
    {
        return [
            'index' => 'framework',
            'type'  => 'posts',
            'body'  => [
                "query" => [
                    "filtered" => [
                        "query"  => [
                            "nested" => [
                                "path"  => "translations.$locale",
                                "query" => [
                                    "multi_match" => [
                                        "query"  => $request->get('query'),
                                        "fields" => ["translations.$locale.title", "translations.$locale.content", "translations.$locale.extract"]
                                    ]
                                ]
                            ]
                        ],
                        "filter" => [
                            "bool" => [
                                "must" => [
                                    [
                                        "term" => [
                                            "account_id" => $manager->account()->id
                                        ]
                                    ],
                                    [
                                        "nested" => [
                                            "path"  => "translations.$locale",
                                            "query" => [
                                                "range" => [
                                                    "translations.$locale.publish_at" => [
                                                        "lte" => "now"
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * @param Request $request
     * @param         $locale
     *
     * @return array
     */
    protected function projectsQuery(Request $request, AccountManager $manager, $locale)
    {
        return [
            'index' => 'framework',
            'type'  => 'projects',
            'body'  => [
                "query" => [
                    "filtered" => [
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
                        ],

                        "filter" => [
                            "bool" => [
                                "must" => [
                                    "term" => [
                                        "account_id" => $manager->account()->id,
                                    ]
                                ]
                            ],
                        ],
                    ]
                ],
            ]
        ];
    }
}