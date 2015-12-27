<?php

namespace Modules\Shop\Http\Admin;

use Illuminate\Http\Request;
use Modules\Shop\Product\PropertyValue;
use Modules\System\Http\AdminController;

/**
 * Class PropertyValueController
 * @package Modules\Shop\Http\Admin
 */
class PropertyValueController extends AdminController
{
    /**
     * @param PropertyValue $values
     * @param Request $request
     * @return string|static
     */
    public function store(PropertyValue $values, Request $request)
    {
        $value = $values->newInstance(translation_input($request));

        if ($value->save()) {
            return $value;
        }

        return json_encode([
            'status' => 'noke',
        ]);
    }

    /**
     * @param PropertyValue $values
     * @param Request $request
     * @return string
     */
    public function update(PropertyValue $values, Request $request)
    {
        $values->fill(translation_input($request));

        if ($values->save()) {
            return json_encode([
                'status' => 'oke',
            ]);
        }

        return json_encode([
            'status' => 'noke',
        ]);
    }

    /**
     * @param PropertyValue $values
     * @return string
     * @throws \Exception
     */
    public function destroy(PropertyValue $values)
    {
        if ($values->id) {
            if ($values->delete()) {
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
