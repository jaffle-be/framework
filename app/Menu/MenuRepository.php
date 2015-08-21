<?php namespace App\Menu;

use App\Account\AccountManager;

class MenuRepository implements MenuRepositoryInterface{

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

    public function __construct(AccountManager $account, Menu $menu, MenuItem $item)
    {
        $this->account = $account;
        $this->menu = $menu;
        $this->item = $item;
    }

    public function findMenu($id)
    {
        return $this->menu->with($this->relations())->find($id);
    }

    public function getMenus()
    {
        return $this->menu->with($this->relations())->get();
    }

    public function createMenu(array $payload)
    {
        $menu = $this->menu->newInstance($payload);

        $menu->account_id = $this->account->account()->id;

        return $menu->save();
    }

    public function cleanMenu(Menu $menu)
    {
        //it should never actually delete the menu itself, as it's provided by the current theme.
        foreach($menu->items as $item)
        {
            $item->delete();
        }

        return true;
    }

    public function sortMenu($menu, $order)
    {
        //this should be a transaction
        foreach($order as $position => $key)
        {
            $model = $menu->items->find($key);
            $model->sort = $position;
            $model->save();
        }

        return true;
    }

    public function createItem(array $payload)
    {
        $item = $this->item->create($payload);

        if($item)
        {
            $item->load($this->itemRelations());

            return $item;
        }
    }

    public function updateItem(MenuItem $item, array $payload)
    {
        $item->load('translations');

        $item->fill($payload);

        $item->save();

        return $item;
    }

    public function deleteItem(MenuItem $item)
    {
        if($item->delete())
        {
            //set 0 for angular
            $item->id = 0;
        }

        return $item;
    }

    /**
     * @return array
     */
    protected function relations()
    {
        return ['items', 'items.children', 'items.translations', 'items.children.translations'];
    }

    protected function itemRelations()
    {
        return ['children', 'translations', 'children.translations'];
    }
}