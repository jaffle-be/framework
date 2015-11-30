<?php

use Modules\Blog\Post;
use Modules\Portfolio\Project;
use Modules\Shop\Gamma\ProductCategorySelection;
use Modules\Shop\Gamma\ProductSelection;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\Category;
use Modules\Shop\Product\Product;
use Modules\Shop\Product\PropertyValue;
use Modules\Users\User;

return [

    /**
     * The name of the index
     * Your app name might be a sane default value.
     */
    'index'    => env('ES_INDEX', 'app'),

    /**
     * All the hosts that are in the cluster.
     */
    'hosts'    => [
        env('APP_ENV') == 'testing' ? 'localhost' : env('ES_HOST'),
    ],

    /**
     * When adding a new type, add it here. This will allow you to easily rebuild the indexes using the build command.
     * Don't forget to add the new type as an argument when you execute the build command. You do not always want
     * to rebuild all your stored indexes.
     *
     * the key equals your database table. the value is either the class or a complex array :-)
     */
    'types'    => [

        'tags'     => [
            'class' => 'Modules\Tags\Tag',
        ],

        'posts'    => [
            'class' => Post::class,
            'with'  => [
                'user' => [
                    'class' => User::class,
                    'key'   => 'user_id'
                ],
            ]
        ],

        'projects' => [
            'class' => Project::class,
        ],

        'product_brands' => [
            'class' => Brand::class,
        ],

        'product_categories' => [
            'class' => Category::class,
        ],

        'products' => [
            'routing' => 'account_id',
            'class' => Product::class,
            'with' => [
                'brand' => [
                    'class' => Brand::class,
                    'key' => 'brand_id',
                ],
                'categories' => [
                    'class' => Category::class,
                    'key' => 'category_id',
                ],
                'properties' => [
                    'class' => PropertyValue::class,
                    'key' => 'product_id',
                ]
            ]
        ],

        'product_gamma' => [
            'routing' => 'account_id',
            'class' => ProductSelection::class,
            'with' => [
                'categories' => [
                    'class' => ProductCategorySelection::class,
                    'key' => 'selection_id',
                ]
            ],
        ],

    ],

    'settings' => [
        'index' => [
            'analysis' => [
                'analyzer'  => [
                    'custom_analyzer'        => [
                        'type'      => 'custom',
                        'tokenizer' => 'nGram',
                        'filter'    => ['standard', 'asciifolding', 'lowercase', 'snowball', 'elision']
                    ],

                    'custom_search_analyzer' => [
                        'type'      => 'custom',
                        'tokenizer' => 'standard',
                        'filter'    => ['standard', 'asciifolding', 'lowercase', 'snowball', 'elision']
                    ],

                    'code'                   => [
                        'tokenizer' => 'pattern',
                        'filter'    => ['standard', 'lowercase', 'code']
                    ],

                    'email'                  => [
                        'tokenizer' => 'uax_url_email',
                        'filter'    => ['email', 'lowercase', 'unique']
                    ]
                ],

                'tokenizer' => [
                    'nGram' => [
                        'type'     => 'nGram',
                        'min_gram' => '2',
                        'max_gram' => 20
                    ],
                ],

                'filter'    => [
                    'snowball' => [
                        'type'     => 'snowball',
                        'language' => 'dutch',
                    ],

                    'code'     => [
                        'type'              => 'pattern_capture',
                        'preserve_original' => 1,
                        'patterns'          => [
                            "(\\p{Ll}+|\\p{Lu}\\p{Ll}+|\\p{Lu}+)",
                            "(\\d+)"
                        ]
                    ],

                    'email'    => [
                        'type'              => 'pattern_capture',
                        'preserve_original' => 1,
                        'patterns'          => [
                            "(\\w+)",
                            "(\\p{L}+)",
                            "(\\d+)",
                            "@(.+)"
                        ]
                    ]
                ]
            ]

        ],
    ]

];