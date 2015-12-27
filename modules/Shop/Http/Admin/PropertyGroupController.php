<?php

namespace Modules\Shop\Http\Admin;

use Illuminate\Http\Request;
use Modules\Shop\Product\PropertyGroup;
use Modules\System\Http\AdminController;

class PropertyGroupController extends AdminController
{
    public function store(Request $request)
    {
        $group = new PropertyGroup(translation_input($request));

        return $group->save() ? $group : false;
    }

    public function update(PropertyGroup $groups, Request $request)
    {
        $groups->fill(translation_input($request));

        return $groups->save() ? $groups : false;
    }

    public function destroy(PropertyGroup $groups)
    {
        if ($groups->properties()->count() == 0) {
            if ($groups->delete()) {
                return json_encode(array(
                    'status' => 'oke',
                ));
            }
        }

        return json_encode(array(
             'status' => 'noke',
         ));
    }

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
