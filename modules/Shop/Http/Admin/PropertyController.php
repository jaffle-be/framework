<?php

namespace Modules\Shop\Http\Admin;

use Illuminate\Http\Request;
use Modules\Shop\Product\Property;
use Modules\Shop\Product\PropertyGroup;
use Modules\System\Http\AdminController;

class PropertyController extends AdminController
{
    public function store(Property $properties, Request $request, PropertyGroup $groups)
    {
        $group = $request->get('group_id');
        $group = $groups->find($group);

        return $properties->create(array_merge(translation_input($request), ['category_id' => $group->category_id]));
    }

    public function update(Property $properties, Request $request)
    {
        $properties->fill(translation_input($request));

        return $properties->save() ? $properties : false;
    }

    public function destroy(Property $properties)
    {
        if ($properties->id) {
            if ($properties->delete()) {
                $properties->id = false;

                return $properties;
            }
        }

        return json_encode([
            'status' => 'noke',
        ]);
    }

    public function sortProperties(Request $request, Property $properties)
    {
        $order = $request->get('order');

        if (count($order)) {
            $properties = $properties->whereIn('id', $order)
                ->get();

            foreach ($properties as $property) {
                $property->sort = array_search($property->id, $order);
                $property->save();
            }
        }
    }

    /**
     * Move from one group to another.
     */
    public function moveProperty(Request $request, PropertyGroup $groups, Property $properties)
    {
        $from = $groups->find($request->get('from'));
        $to = $groups->find($request->get('to'));
        $property = $properties->find($request->get('property'));
        $position = $request->get('position');

        //we move away from a group, meaning, everything that was behind this element
        //will now get a lower sort.
        Property::where('category_id', $property->category_id)
            ->where('group_id', $from->id)
            ->where('sort', '>', $property->sort)
            ->update([
                'sort' => \DB::raw('sort - 1'),
            ]);

        //items that need to come behind our property get a higher sort
        Property::where('category_id', $property->category_id)
            ->where('group_id', $to->id)
            ->where('sort', '>=', $position)
            ->update([
                'sort' => \DB::raw('sort + 1'),
            ]);

        //finally we save the property with it's new group and position
        $property->group_id = $to->id;
        $property->sort = $position;
        $property->save();
    }
}
