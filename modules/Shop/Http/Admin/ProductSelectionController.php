<?php namespace Modules\Shop\Http\Admin;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Modules\Account\AccountManager;
use Modules\Search\SearchServiceInterface;
use Modules\Shop\Gamma\ProductSelection;
use Modules\Shop\Jobs\UpdateProduct;
use Modules\Shop\Product\Product;
use Modules\System\Http\AdminController;

class ProductSelectionController extends AdminController{

    public function index(Request $request, ProductSelection $selections, SearchServiceInterface $search, Product $products, AccountManager $account)
    {
        $account = $account->account();
        //bazinga, we can now fully search using elasticsearch.
        //we don't care about the nearly realtime
        //even a minute would be acceptable, for blazing fast sites.
        //allright

        $query = [
            'index' => config('search.index'),
            'type'  => $selections->getSearchableType(),
            'body'  => [
                'query' => [
                    'filtered' => [
                        'query'  => [
                            'match_all' => new \StdClass()
                        ],
                    ]
                ]
            ],
            'routing' => $account->id
        ];

        $relations = ['product', 'product.translations', 'product.images', 'product.images.sizes' => function($query){
            $query->dimension(150);
        }];

        $result = $search->search($selections->getSearchableType(), $query, $relations);

        return $result;
    }

    public function show(Product $product)
    {
        $product->load($this->relations());

        return $product;
    }

    public function update(Product $product, Request $request)
    {
        $product->load($this->relations());

        $payload = [
            'product'  => $product,
            'input' => translation_input($request, ['name', 'title', 'content', 'published'])
        ];

        if (!$this->dispatchFromArray(UpdateProduct::class, $payload)) {
            return response('500', 'something bad happened');
        }

        return $product;
    }

    public function batchPublish(Request $request, Product $product)
    {
        $ids = $request->get('products', []);

        if(is_array($ids) && count($ids))
        {
            $products = $product->whereIn('products.id', $ids)
                ->get();

            foreach($products as $product)
            {
                $translation = $product->translate($request->get('locale'));

                if($translation)
                {
                    $translation->published = true;
                }

                $translation->save();
            }
        }
    }

    public function batchUnpublish(Request $request, Product $product)
    {
        $ids = $request->get('products', []);

        if(is_array($ids) && count($ids))
        {
            $products = $product->whereIn('products.id', $ids)
                ->get();

            foreach($products as $product)
            {
                $translation = $product->translate($request->get('locale'));

                if($translation)
                {
                    $translation->published = false;
                }

                $translation->save();
            }
        }
    }

    public function overview()
    {
        return view('shop::admin.selections.overview');
    }

    public function detail()
    {
        return 'selection detail';

        return view('shop::admin.selections.detail');
    }

    protected function relations()
    {
        return ['translations', 'translations'];
    }

}