<?php

namespace Modules\Shop\Http\Admin;

use Illuminate\Http\Request;
use Modules\Shop\Product\Category;
use Modules\System\Http\AdminController;

/**
 * Class CategoryController
 * @package Modules\Shop\Http\Admin
 */
class CategoryController extends AdminController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function suggest(Request $request)
    {
        $results = suggest_completion('product_categories', $request->get('query'), $request->get('locale'));

        return response()->json($results);
    }

    /**
     * @param Category $category
     * @param Request $request
     * @return array
     */
    public function index(Category $category, Request $request)
    {
        return suggest_completion('product_categories', $request->get('query'), $request->get('locale'));
    }

    /**
     * @param Request $request
     * @param Category $categories
     * @return $this
     */
    public function store(Request $request, Category $categories)
    {
        $input = translation_input($request);

        $category = $categories->create($input);

        return $category->load('translations');
    }

    /**
     * @param Category $category
     * @param Request $request
     * @return bool
     */
    public function update(Category $category, Request $request)
    {
        $category = $category->find($request->get('id'));
        $category->load(['translations']);

        $category->fill(translation_input($request));

        return $category->save() ? $category : false;
    }

    /**
     * @param Category $category
     * @param Request $request
     */
    public function destroy(Category $category, Request $request)
    {
    }
}
