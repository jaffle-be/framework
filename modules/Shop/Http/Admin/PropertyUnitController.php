<?php

namespace Modules\Shop\Http\Admin;

use Illuminate\Http\Request;
use Modules\Shop\Product\PropertyUnit;
use Modules\System\Http\AdminController;

class PropertyUnitController extends AdminController
{
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
