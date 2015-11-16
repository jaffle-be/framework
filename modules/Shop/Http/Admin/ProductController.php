<?php namespace Modules\Shop\Http\Admin;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Modules\Account\AccountManager;
use Modules\Search\SearchServiceInterface;
use Modules\Shop\Gamma\GammaSubscriptionManager;
use Modules\Shop\Jobs\UpdateProduct;
use Modules\Shop\Product\Product;
use Modules\System\Http\AdminController;

class ProductController extends AdminController
{

    public function index(Request $request, Product $products, SearchServiceInterface $search, GammaSubscriptionManager $subscriptions)
    {
        $thumbnailRequirements = function ($query) {
            $query->dimension(150);
        };

        //only products from the subscription accounts
        $indexes = $this->indexesToUse($subscriptions);

        $query = [
            'index'   => $indexes,
            'type'    => $products->getSearchableType(),
            'body'    => [
                'query' => [
                    'filtered' => [
                        'query' => [
                            'match_all' => new \StdClass()
                        ],
                    ]
                ]
            ]
        ];

        return $search->search('products', $query, [
            'images',
            'images.sizes' => $thumbnailRequirements,
            'images.translations'
        ]);

        $query = Product::with(['translations']);

        $value = $request->get('query');
        $locale = $request->get('locale');

        if (!empty($value)) {
            $query->whereHas('translations', function ($q) use ($value, $locale) {
                $q->where('locale', $locale);
                $q->where(function ($q) use ($value) {
                    $q->where('name', 'like', '%' . $value . '%')
                        ->orWhere('content', 'like', '%' . $value . '%');
                });
            });
        }

        return $query->paginate();
    }

    public function store(Request $request, Product $product, Guard $guard, AccountManager $accounts)
    {
        $input = translation_input($request);

        $product = $product->newInstance($input);

        $product->account_id = $accounts->account()->id;

        $product->user()->associate($guard->user());

        if ($product->save()) {
            return $product;
        }

        return json_encode(array(
            'status' => 'noke'
        ));
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
            'product' => $product,
            'input'   => translation_input($request, ['name', 'title', 'content', 'published'])
        ];

        if (!$this->dispatchFromArray(UpdateProduct::class, $payload)) {
            return response('500', 'something bad happened');
        }

        return $product;
    }

    public function destroy(Product $product)
    {
        return $this->deleteProduct($product);
    }

    public function batchDestroy(Request $request, Product $product)
    {
        $ids = $request->get('products', []);

        if (is_array($ids) && count($ids)) {
            $products = $product->whereIn('products.id', $ids)
                ->get();

            foreach ($products as $product) {
                $this->deleteProduct($product);
            }
        }
    }

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

    public function overview()
    {
        return view('shop::admin.product.overview');
    }

    public function detail()
    {
        return view('shop::admin.product.detail');
    }

    protected function relations()
    {
        return ['translations', 'translations'];
    }

    /**
     * @param Product $product
     *
     * @return Product
     * @throws \Exception
     */
    protected function deleteProduct(Product $product)
    {
        //need to make sure everything is deleted in gamma.
        //this will happen if we detach categories before deleting.
        $product->categories()->sync([]);

        if ($product->delete()) {
            $product->id = false;
        }

        return $product;
    }

    /**
     * @param GammaSubscriptionManager $subscriptions
     *
     * @return mixed
     */
    protected function indexesToUse(GammaSubscriptionManager $subscriptions)
    {
        $accounts = $subscriptions->getSubscribedAccounts();

        $aliases = $accounts->lists('alias')->toArray();

        return implode(',', $aliases);
    }

}