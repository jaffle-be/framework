<?php

namespace Modules\Shop\Http\Admin;

use Illuminate\Http\Request;
use Modules\System\Http\AdminController;

/**
 * Class BrandController
 * @package Modules\Shop\Http\Admin
 */
class BrandController extends AdminController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function suggest(Request $request)
    {
        $results = suggest_completion('product_brands', $request->get('query'), $request->get('locale'));

        return response()->json($results);
    }
}
