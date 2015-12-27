<?php

namespace Modules\Shop\Http\Admin;

use Illuminate\Http\Request;
use Modules\Shop\Product\PropertyOption;
use Modules\System\Http\AdminController;

/**
 * Class PropertyOptionController
 * @package Modules\Shop\Http\Admin
 */
class PropertyOptionController extends AdminController
{
    /**
     * @param PropertyOption $options
     * @param Request $request
     * @return string|static
     */
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

    /**
     * @param PropertyOption $options
     * @param Request $request
     * @return string
     */
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

    /**
     * @param PropertyOption $options
     * @return string
     * @throws \Exception
     */
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
