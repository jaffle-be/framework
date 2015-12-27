<?php

namespace Modules\Shop\Http\Admin;

use Illuminate\Http\Request;
use Modules\Shop\Product\PropertyGroup;
use Modules\System\Http\AdminController;

/**
 * Class PropertyGroupController
 * @package Modules\Shop\Http\Admin
 */
class PropertyGroupController extends AdminController
{
    /**
     * @param Request $request
     * @return bool|PropertyGroup
     */
    public function store(Request $request)
    {
        $group = new PropertyGroup(translation_input($request));

        return $group->save() ? $group : false;
    }

    /**
     * @param PropertyGroup $groups
     * @param Request $request
     * @return bool|PropertyGroup
     */
    public function update(PropertyGroup $groups, Request $request)
    {
        $groups->fill(translation_input($request));

        return $groups->save() ? $groups : false;
    }

    /**
     * @param PropertyGroup $groups
     * @return string
     * @throws \Exception
     */
    public function destroy(PropertyGroup $groups)
    {
        if ($groups->properties()->count() == 0) {
            if ($groups->delete()) {
                return json_encode([
                    'status' => 'oke',
                ]);
            }
        }

        return json_encode([
            'status' => 'noke',
        ]);
    }

    /**
     * @param Request $request
     * @param PropertyGroup $groups
     */
    public function sortGroups(Request $request, PropertyGroup $groups)
    {
        $order = $request->get('order');

        if (count($order)) {
            $groups = $groups->whereIn('id', $order)
                ->get();

            foreach ($groups as $group) {
                $group->sort = array_search($group->id, $order);
                $group->save();
            }
        }
    }
}
