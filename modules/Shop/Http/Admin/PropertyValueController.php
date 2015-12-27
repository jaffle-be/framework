<?php

namespace Modules\Shop\Http\Admin;

use Illuminate\Http\Request;
use Modules\Shop\Product\PropertyValue;
use Modules\System\Http\AdminController;

class PropertyValueController extends AdminController
{

    public function store(PropertyValue $values, Request $request)
    {
        $value = $values->newInstance(translation_input($request));

        if ($value->save()) {
            return $value;
        }

        return json_encode(array(
            'status' => 'noke',
        ));
    }

    public function update(PropertyValue $values, Request $request)
    {
        $values->fill(translation_input($request));

        if ($values->save()) {
            return json_encode(array(
                'status' => 'oke',
            ));
        }

        return json_encode(array(
            'status' => 'noke',
        ));
    }

    public function destroy(PropertyValue $values)
    {
        if ($values->id) {
            if ($values->delete()) {
                return json_encode(array(
                    'status' => 'oke',
                ));
            }
        }

        return json_encode(array(
            'status' => 'noke',
        ));
    }
}
