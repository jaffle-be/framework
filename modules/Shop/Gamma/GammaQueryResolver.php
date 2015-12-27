<?php

namespace Modules\Shop\Gamma;

use Illuminate\Http\Request;
use Modules\Account\AccountManager;
use Modules\Search\SearchResponder;
use Modules\Search\SearchServiceInterface;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\Category;
use Modules\Shop\Product\Property;

class GammaQueryResolver
{
    use SearchResponder;

    protected $request;

    protected $service;

    protected $account;

    protected $brands;

    public function __construct(Request $request, SearchServiceInterface $search, AccountManager $account, Brand $brands)
    {
        $this->request = $request;
        $this->service = $search;
        $this->account = $account;
        $this->brands = $brands;
    }

    public function resolve(Category $category)
    {
        $index = $this->account->account()->alias;

        $query = [
            'index' => $index,
            'type' => 'product_gamma',
            'body' => $this->getQuery($category),
        ];

        $result = $this->service->getClient()->search($query);

        $properties = $this->properties($result);

        return [
            'products' => $this->products($result),
            'brands' => $this->brands($result),
            'properties' => $properties,
            'values' => $this->values($category, $properties),
        ];
    }

    protected function getQuery(Category $category)
    {
        return [
            'query' => [
                'nested' => [
                    'path' => 'categories',
                    'query' => [
                        'filtered' => [
                            'query' => [
                                'match_all' => [],
                            ],
                            'filter' => [
                                'term' => [
                                    'categories.category_id' => $category->id,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'aggs' => [
                'brands' => [
                    'terms' => [
                        'field' => 'brand_id',
                        'size' => 100,
                    ],
                ],
                'properties' => $this->propertyAggregations($category),
            ],
        ];
    }

    /**
     * @param $result
     *
     * @return array|\Illuminate\Pagination\LengthAwarePaginator
     */
    protected function products($result)
    {
        return $this->response($result, [
            'product',
            'product.translations',
        ], 15, new ProductSelection());
    }

    protected function brands($result)
    {
        $buckets = $this->bucketizeBrands($result);

        $brands = $this->brands->with([
            'translations',
        ])->whereIn('id', array_keys($buckets))->get();

        foreach ($brands as $brand) {
            $brand->product_count = $buckets[$brand->id];
        }

        return $brands;
    }

    protected function properties($result)
    {
        $properties = $result['aggregations']['properties'];
        unset($properties['doc_count']);

        $results = [];

        foreach ($properties as $filter => $sub_agg) {
            $property_id = str_replace('property_filter_', '', $filter);

            $results[$property_id] = [];

            $buckets = $sub_agg['property_'.$property_id]['buckets'];

            foreach ($buckets as $bucket) {
                $results[$property_id][$bucket['key']] = $bucket['doc_count'];
            }
        }

        return $results;
    }

    /**
     * @param $result
     *
     * @return array
     */
    protected function bucketizeBrands($result)
    {
        $buckets = $result['aggregations']['brands']['buckets'];

        $tmp = [];

        foreach ($buckets as $bucket) {
            $tmp[$bucket['key']] = $bucket['doc_count'];
        }

        $buckets = $tmp;

        return $tmp;
    }

    protected function propertyAggregations($category)
    {
        $original = $category->original_id ? $category->original : $category;

        $aggs = [];

        //run through using groups, since that's being used on the website,
        //we end up avoiding a few extra queries likes this.
        foreach ($original->propertyGroups as $group) {
            foreach ($group->properties as $property) {
                $aggs['property_filter_'.$property->id] = $this->propertyFilterAggregation($property);
            }
        }

        return [
            'nested' => [
                'path' => 'properties',
            ],
            'aggs' => $aggs,
        ];
    }

    /**
     * @param Property $property
     *
     * @return array
     */
    protected function propertyValueAggregation(Property $property)
    {
        if ($property->type == 'string') {
            return [
                'terms' => [
                    'field' => 'properties.boolean',
                    'size' => 10,
                ],
            ];
        } elseif ($property->type == 'options') {
            return [
                'terms' => [
                    'field' => 'properties.option_id',
                    'size' => 10,
                ],
            ];
        }

        return [
            'terms' => [
                'field' => 'properties.'.$property->type,
                'size' => 10,
            ],
        ];
    }

    /**
     * @param $property
     *
     * @return array
     */
    protected function propertyFilterAggregation($property)
    {
        return [
            'filter' => [
                'term' => [
                    'properties.property_id' => $property->id,
                ],
            ],
            'aggs' => [
                'property_'.$property->id => $this->propertyValueAggregation($property),
            ],
        ];
    }

    protected function values($category, $properties)
    {
        //need to load all the values for this property
    }
}
