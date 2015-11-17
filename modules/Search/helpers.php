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
            'body'  => [
                "not_important_name" => [
                    "text"       => $query,
                    "completion" => [
                        "field" => $type . '_suggest_' . $locale,
                        "fuzzy" => [
                            "fuzziness" => strlen($query) > 5 ? (int) (strlen($query) / 2) + 1  : 1,
                            "max_expansions" => 10,
                            "prefix_length" => 0,
                        ]
                    ],
                ]
            ]
        ];

        $client = app('Modules\Search\SearchServiceInterface')->getClient();
        $results = $client->suggest($query);

        return array_map(function ($item) {
            return $item['payload'];
        }, $results['not_important_name'][0]['options']);
    }
}