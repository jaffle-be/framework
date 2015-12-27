<?php

namespace Modules\Shop\Http\Admin;

use Illuminate\Http\Request;
use Modules\Shop\Product\Category;
use Modules\System\Http\AdminController;

class CategoryController extends AdminController
{

    public function suggest(Request $request)
    {
        $results = suggest_completion('product_categories', $request->get('query'), $request->get('locale'));

        return response()->json($results);
    }

    public function index(Category $category, Request $request)
    {
        return suggest_completion('product_categories', $request->get('query'), $request->get('locale'));
    }

    public function store(Request $request, Category $categories)
    {
        $input = translation_input($request);

        $category = $categories->create($input);

        return $category->load('translations');
    }

    public function update(Category $category, Request $request)
    {
        $category = $category->find($request->get('id'));
        $category->load(['translations']);

        $category->fill(translation_input($request));

        return $category->save() ? $category : false;
    }

    public function destroy(Category $category, Request $request)
    {
    }
}
