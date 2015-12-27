<?php

if (!function_exists('suggest_completion')) {
    /**
     * @param $type
     * @param $query
     * @param $locale
     *
     * @return array
     */
    function suggest_completion($type, $query, $locale)
    {
        $query = [
            'index' => config('search.index'),
            'body' => [
                'not_important_name' => [
                    'text' => $query,
                    'completion' => [
                        'field' => $type.'_suggest_'.$locale,
                        'fuzzy' => [
                            //for every 5 chars, we allow a typo if the query is longer then 3,
                            //if not longer, no typos allowed
                            'fuzziness' => strlen($query) > 3 ? (int) floor(strlen($query) / 5) + 1 : 0,
                            'max_expansions' => 10,
                            'prefix_length' => 0,
                        ],
                        'size' => 10,
                    ],
                ],
            ],
        ];

        $client = app('Modules\Search\SearchServiceInterface')->getClient();
        $results = $client->suggest($query);

        return array_map(function ($item) {
            return $item['payload'];
        }, $results['not_important_name'][0]['options']);
    }
}
