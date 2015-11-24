<?php namespace Modules\Shop\Http\Admin;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Modules\Account\AccountManager;
use Modules\Media\MediaWidgetPreperations;
use Modules\Search\SearchServiceInterface;
use Modules\Shop\Gamma\GammaSubscriptionManager;
use Modules\Shop\Jobs\UpdateProduct;
use Modules\Shop\Product\Category;
use Modules\Shop\Product\Product;
use Modules\Shop\Product\Property;
use Modules\Shop\Product\PropertyGroup;
use Modules\System\Http\AdminController;
use Modules\System\Locale;

class ProductController extends AdminController
{
    use MediaWidgetPreperations;

    public function suggest(Request $request)
    {
        return suggest_completion('products', $request->get('query'), $request->get('locale'));
    }

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
            'brand',
            'brand.translations',
            'images',
            'images.sizes' => $thumbnailRequirements,
            'images.translations'
        ]);
    }

    public function store(Request $request, Product $product, Guard $guard, AccountManager $accounts)
    {
        $this->validate($request, [
            'brand_id' => 'required|exists:product_brands,id',
            //these rules are not sufficient. but doing numeric and size works totally wrong
            'name' => 'required|string',
            'ean' => 'string|size:13',
        ]);

        $input = translation_input($request);

        $name = $request->get('name');

        foreach(Locale::all() as $locale)
        {
            $input[$locale->slug] = ['name' => $name];
        }

        $product = $product->newInstance($input);

        $product->account_id = $accounts->account()->id;

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

        $this->prepareMedia($product);

        $this->prepareProperties($product);

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

    public function addCategory(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'exists:products,id',
            'category_id' => 'exists:product_categories,id',
        ]);

        $product = Product::find($request->get('product_id'));
        $category = Category::find($request->get('category_id'));

        $product->load('categories');

        $added = new Collection();

        if(!$category->original_id)
        {
            //we can only add a main category if the count is 0
            if($product->categories->count() == 0)
            {
                $category->load(['synonyms', 'synonyms.translations', 'translations']);
                //add main category, and each synonym.
                $this->doCategoryAttach($product, $category, $added);

                foreach($category->synonyms as $synonym)
                {
                    $this->doCategoryAttach($product, $synonym, $added);
                }
            }
        }

        if($category->original_id)
        {
            $category->load(['translations']);

            $this->doCategoryAttach($product, $category, $added);
        }

        $groups = isset($baseProperties) ? $this->propertyGroups($product->mainCategory()) : null;

        return new Collection([
            'categories' => $added,
            'propertyGroups' => $groups,
            'baseProperties' => isset($baseProperties) ? $this->baseProperties($product->mainCategory(), $groups) : null,
            'hasMainCategory' => isset($baseProperties) ? true : false,
        ]);
    }

    public function removeCategory(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'exists:products,id',
            'category_id' => 'exists:product_categories,id',
        ]);

        $product = Product::find($request->get('product_id'));
        $category = Category::find($request->get('category_id'));

        $product->load('categories');
        $category->load('translations');

        if($product->categories->contains($category->id))
        {
            //is the category the main category or a synonym?
            if(!$category->original_id)
            {
                //we can only have 1 main category and synonyms to that category
                //so we can do an empty sync here
                $product->categories()->sync([]);

                return json_encode(['status' => 'flushed']);
            }
            else{
                $product->categories()->detach($category);

                return $category;
            }
        }

        return json_encode([
            'status' => false
        ]);
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
        return ['translations', 'brand', 'brand.translations', 'categories', 'categories.translations',
            'properties', 'properties.translations', 'properties.option',
        ];
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

    /**
     * @param $product
     * @param $category
     * @param $added
     */
    protected function doCategoryAttach($product, $category, $added)
    {
        if (!$product->categories->contains($category->id)) {
            $product->categories()->attach($category);
            $added->push($category);
        }
    }

    protected function prepareProperties(Product $product)
    {
        $category = $product->mainCategory();

        if($category)
        {
            $groups = $this->propertyGroups($product->mainCategory());

            $product->hasMainCategory = true;
            $product->baseProperties = $this->baseProperties($category, $groups);
            $product->propertyGroups = $groups;
            $product->setRelation('properties',$product->properties->keyBy('property_id'));
        }
    }

    protected function propertyGroups(Category $category)
    {
        return PropertyGroup::where('category_id', $category->id)->with('translations')->get();
    }

    protected function baseProperties(Category $category, Collection $groups)
    {
        $properties = Property::categoryProperties($category);

        $properties = $properties->groupBy('group_id');

        //make sure that each category is a collection,
        //so we can drop items in that group-sortable in the UI
        foreach($groups as $group)
        {
            if(!$properties->has($group->id)){
                $properties->put($group->id, new Collection());
            };
        }

        return $properties;
    }

}