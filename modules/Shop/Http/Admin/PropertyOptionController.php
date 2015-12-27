<?php

namespace Modules\Shop\Http\Admin;

use Illuminate\Http\Request;
use Modules\Shop\Product\PropertyOption;
use Modules\System\Http\AdminController;

class PropertyOptionController extends AdminController
{
    public function store(PropertyOption $options, Request $request)
    {
        $option = $options->newInstance(translation_input($request));

        if ($option->save()) {
            return $option;
        }

        return json_encode([
            'status' => 'noke',
        ]);
    }

    public function update(PropertyOption $options, Request $request)
    {
        $options->fill(translation_input($request));

        if ($options->save()) {
            return json_encode([
                'status' => 'oke',
            ]);
        }

        return json_encode([
            'status' => 'noke',
        ]);
    }

    public function destroy(PropertyOption $options)
    {
        if ($options->id) {
            if ($options->delete()) {
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
