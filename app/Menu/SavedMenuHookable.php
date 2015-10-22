<?php namespace App\Menu;

use App\Account\AccountManager;
use App\Pages\Page;

class SavedMenuHookable
{

    protected $account;

    protected $menu;

    public function __construct(AccountManager $accountManager, MenuRepositoryInterface $menu)
    {
        $this->account = $accountManager->account();

        $this->menu = $menu;
    }

    public function handle($model)
    {
        if ($model instanceof MenuHookable) {
            //find the menu item
            if ($model instanceof Page) {
                $items = MenuItem::where('page_id', $model->id)->get();
            }

            $translations = $model->getMenuLocalisedNames();

            foreach ($items as $item) {
                //foreach locale, see if the translation in the menu item is set
                //if not, update the item with the data from the menu hookable item
                $payload = [];

                foreach ($this->account->locales as $locale) {
                    $translation = $item->translateOrNew($locale->slug);

                    if (empty($translation->name)) {
                        $payload[$locale->slug] = ['name' => $translations[$locale->slug]];
                    }
                }

                $this->menu->updateItem($item, $payload);
            }
        }
    }

}