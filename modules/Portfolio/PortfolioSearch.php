<?php

namespace Modules\Portfolio;

use Illuminate\Http\Request;
use Modules\Account\AccountManager;

/**
 * Class PortfolioSearch
 * @package Modules\Portfolio
 */
trait PortfolioSearch
{
    /**
     * @param Request $request
     * @param AccountManager $manager
     * @param $locale
     * @return array
     */
    protected function projectsQuery(Request $request, AccountManager $manager, $locale)
    {
        return [
            'index' => 'framework',
            'type' => 'projects',
            'body' => [
                'query' => [
                    'filtered' => [
                        'query' => [
                            'nested' => [
                                'path' => 'translations.'.$locale,
                                'query' => [
                                    'multi_match' => [
                                        'query' => $request->get('query'),
                                        'fields' => ["translations.$locale.title", "translations.$locale.content"],

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
                                                'term' => [
                                                    "translations.$locale.published" => true,
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
