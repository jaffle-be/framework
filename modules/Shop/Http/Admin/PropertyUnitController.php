<?php

namespace Modules\Shop\Http\Admin;

use Illuminate\Http\Request;
use Modules\Shop\Product\PropertyUnit;
use Modules\System\Http\AdminController;

/**
 * Class PropertyUnitController
 * @package Modules\Shop\Http\Admin
 */
class PropertyUnitController extends AdminController
{
    /**
     * @param PropertyUnit $units
     * @param Request $request
     * @return string|static
     */
    public function store(PropertyUnit $units, Request $request)
    {
        $unit = $units->newInstance(translation_input($request));

        if ($unit->save()) {
            return $unit;
        }

        return json_encode([
            'status' => 'noke',
        ]);
    }

    /**
     * @param PropertyUnit $units
     * @param Request $request
     * @return string
     */
    public function update(PropertyUnit $units, Request $request)
    {
        $units->fill(translation_input($request));

        if ($units->save()) {
            return json_encode([
                'status' => 'oke',
            ]);
        }

        return json_encode([
            'status' => 'noke',
        ]);
    }

    /**
     * @param PropertyUnit $units
     * @return string
     * @throws \Exception
     */
    public function destroy(PropertyUnit $units)
    {
        if ($units->id) {
            if ($units->delete()) {
                return json_encode([
                    'status' => 'oke',
                ]);
            }
        }

        return json_encode([
            'status' => 'noke',
        ]);
    }
}
