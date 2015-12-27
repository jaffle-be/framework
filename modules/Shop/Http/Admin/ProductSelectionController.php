<?php

namespace Modules\Shop\Http\Admin;

use Illuminate\Http\Request;
use Modules\Account\AccountManager;
use Modules\Search\SearchServiceInterface;
use Modules\Shop\Gamma\ProductSelection;
use Modules\Shop\Jobs\UpdateProduct;
use Modules\Shop\Product\Product;
use Modules\System\Http\AdminController;

/**
 * Class ProductSelectionController
 * @package Modules\Shop\Http\Admin
 */
class ProductSelectionController extends AdminController
{
    /**
     * @param Request $request
     * @return array
     */
    public function suggest(Request $request)
    {
        return suggest_completion('product_gamma', $request->get('query'), $request->get('locale'));
    }

    /**
     * @param Request $request
     * @param ProductSelection $selections
     * @param SearchServiceInterface $search
     * @param Product $products
     * @param AccountManager $account
     * @return mixed
     */
    public function index(Request $request, ProductSelection $selections, SearchServiceInterface $search, Product $products, AccountManager $account)
    {
        $account = $account->account();
        //bazinga, we can now fully search using elasticsearch.
        //we don't care about the nearly realtime
        //even a minute would be acceptable, for blazing fast sites.
        //allright

        $query = [
            'index' => config('search.index'),
            'type' => $selections->getSearchableType(),
            'body' => [
                'query' => [
                    'filtered' => [
                        'query' => [
                            'match_all' => new \StdClass(),
                        ],
                    ],
                ],
            ],
            'routing' => $account->id,
        ];

        $relations = [
            'product',
            'product.translations',
            'product.images',
            'product.images.sizes' => function ($query) {
                $query->dimension(150);
            },
            //load brand from product, not from selection
            //this will make sure the title gets displayed
            //see ProductService in angular
            'product.brand',
            'product.brand.translations',
        ];

        $result = $search->search($selections->getSearchableType(), $query, $relations);

        return $result;
    }

    /**
     * @param Product $product
     * @return Product
     */
    public function show(Product $product)
    {
        $product->load($this->relations());

        return $product;
    }

    /**
     * @param Product $product
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Product|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Product $product, Request $request)
    {
        $product->load($this->relations());

        if (! $this->dispatch(new UpdateProduct($product, translation_input($request, ['name', 'title', 'content', 'published'])))) {
            return response('500', 'something bad happened');
        }

        return $product;
    }

    /**
     * @param Request $request
     * @param Product $product
     */
    public function batchPublish(Request $request, Product $product)
    {
        $ids = $request->get('products', []);

        if (is_array($ids) && count($ids)) {
            $products = $product->whereIn('products.id', $ids)
                ->get();

            foreach ($products as $product) {
                $translation = $product->translate($request->get('locale'));

                if ($translation) {
                    $translation->published = true;
                }

                $translation->save();
            }
        }
    }

    /**
     * @param Request $request
     * @param Product $product
     */
    public function batchUnpublish(Request $request, Product $product)
    {
        $ids = $request->get('products', []);

        if (is_array($ids) && count($ids)) {
            $products = $product->whereIn('products.id', $ids)
                ->get();

            foreach ($products as $product) {
                $translation = $product->translate($request->get('locale'));

                if ($translation) {
                    $translation->published = false;
                }

                $translation->save();
            }
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function overview()
    {
        return view('shop::admin.selections.overview');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function detail()
    {
        return 'selection detail';

        return view('shop::admin.selections.detail');
    }

    /**
     * @return array
     */
    protected function relations()
    {
        return ['translations', 'translations'];
    }
}
