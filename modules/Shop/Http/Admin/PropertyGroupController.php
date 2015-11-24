<?php namespace Modules\Shop\Http\Admin;

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

    public function sortGroups(Request $request, PropertyGroup $groups)
    {
        $order = $request->get('order');

        if(count($order))
        {
            $groups = $groups->whereIn('id', $order)
                ->get();

            foreach($groups as $group)
            {
                $group->sort = array_search($group->id, $order);
                $group->save();
            }
        }
    }

}