<?php

namespace Modules\Menu;

use Modules\Account\AccountManager;

/**
 * Class MenuRepository
 * @package Modules\Menu
 */
class MenuRepository implements MenuRepositoryInterface
{
    /**
     * @var AccountManager
     */
    protected $account;

    /**
     * @var Menu
     */
    protected $menu;

    /**
     * @var MenuItem
     */
    protected $item;

    /**
     * @param AccountManager $account
     * @param Menu $menu
     * @param MenuItem $item
     */
    public function __construct(AccountManager $account, Menu $menu, MenuItem $item)
    {
        $this->account = $account;
        $this->menu = $menu;
        $this->item = $item;
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function findMenu($id)
    {
        return $this->menu->with($this->relations())->find($id);
    }

    /**
     *
     */
    protected function relations()
    {
        return ['items', 'items.children', 'items.translations', 'items.children.translations', 'items.page'/*'items.routable'*/];
    }

    /**
     * @return mixed
     */
    public function getMenus()
    {
        return $this->menu->with($this->relations())->orderBy('id')->get();
    }

    /**
     * @param array $payload
     * @return bool
     */
    public function createMenu(array $payload)
    {
        $menu = $this->menu->newInstance($payload);

        $menu->account_id = $this->account->account()->id;

        return $menu->save();
    }

    /**
     * @param Menu $menu
     * @return bool
     */
    public function cleanMenu(Menu $menu)
    {
        //it should never actually delete the menu itself, as it's provided by the current theme.
        foreach ($menu->items as $item) {
            $item->delete();
        }

        return true;
    }

    /**
     * @param $menu
     * @param $order
     * @return bool
     */
    public function sortMenu($menu, $order)
    {
        //this should be a transaction
        foreach ($order as $position => $key) {
            $model = $menu->items->find($key);
            $model->sort = $position;
            $model->save();
        }

        return true;
    }

    /**
     * @param array $payload
     * @return static
     */
    public function createItem(array $payload)
    {
        $item = $this->item->newInstance($payload);

        $item->sort = $this->item->where('menu_id', $payload['menu_id'])->whereNull('parent_id')->count();

        $item->save();

        if ($item) {
            $item->load($this->itemRelations());

            return $item;
        }
    }

    /**
     * @return array
     */
    protected function itemRelations()
    {
        return ['children', 'translations', 'children.translations'];
    }

    /**
     * @param MenuItem $item
     * @param array $payload
     * @return MenuItem
     */
    public function updateItem(MenuItem $item, array $payload)
    {
        $item->load('translations');

        $item->fill($payload);

        $item->save();

        return $item;
    }

    /**
     * @param MenuItem $item
     * @return MenuItem
     * @throws \Exception
     */
    public function deleteItem(MenuItem $item)
    {
        if ($item->delete()) {
            //set 0 for angular
            $item->id = 0;
        }

        return $item;
    }
}
