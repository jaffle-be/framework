<?php namespace App\Menu\Http\Admin;

use App\Menu\Menu;
use App\System\Http\AdminController;
use Illuminate\Http\Request;

class MenuController extends AdminController
{

    public function index(Menu $menu)
    {
        return $menu->with($this->relations())->get();
    }

    public function store(Request $request, Menu $menu)
    {
        $this->validate($request, ['name' => 'required']);

        return $menu->create([
            'name' => $request->get('name')
        ]);
    }

    public function destroy(Menu $menu)
    {
        //it should never actually delete the menu itself, as it's provided by the current theme.
        foreach($menu->items as $item)
        {
            $item->delete();
        }

        return $menu->with($this->relations())->find($menu->id);
    }

    public function sort(Menu $menu, Request $request)
    {
        $order = $request->get('order');

        foreach($order as $position => $key)
        {
            $model = $menu->items->find($key);
            $model->sort = $position;
            $model->save();
        }
    }

    /**
     * @return array
     */
    protected function relations()
    {
        $relations = ['items', 'items.translations', 'items.children', 'items.children.translations'];

        return $relations;
    }

}