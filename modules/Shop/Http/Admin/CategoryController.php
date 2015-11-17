<?php namespace Modules\Shop\Http\Admin;

use Illuminate\Http\Request;
use Modules\System\Http\AdminController;

class CategoryController extends AdminController
{

    public function suggest(Request $request)
    {
        $results = suggest_completion('product_categories', $request->get('query'), $request->get('locale'));

        return response()->json($results);
    }

}