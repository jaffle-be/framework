<?php

namespace Modules\Blog;

use Illuminate\Http\Request;
use Modules\Account\AccountManager;

/**
 * Class BlogSearch
 * @package Modules\Blog
 */
trait BlogSearch
{
    /**
     * @param Request $request
     * @param AccountManager $manager
     * @param $locale
     * @return array
     */
    protected function postsQuery(Request $request, AccountManager $manager, $locale)
    {
        return [
            'index' => 'framework',
            'type' => 'posts',
            'body' => [
                'query' => [
                    'filtered' => [
                        'query' => [
                            'nested' => [
                                'path' => "translations.$locale",
                                'query' => [
                                    'multi_match' => [
                                        'query' => $request->get('query'),
                                        'fields' => ["translations.$locale.title", "translations.$locale.content", "translations.$locale.extract"],
                                    ],
                                ],
                            ],
                        ],
                        'filter' => [
                            'bool' => [
                                'must' => [
                                    [
                                        'term' => [
                                            'account_id' => $manager->account()->id,
                                        ],
                                    ],
                                    [
                                        'nested' => [
                                            'path' => "translations.$locale",
                                            'query' => [
                                                'range' => [
                                                    "translations.$locale.publish_at" => [
                                                        'lte' => 'now',
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
