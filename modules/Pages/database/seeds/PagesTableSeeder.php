<?php

use Modules\Account\Account;
use Modules\Pages\Page;
use Modules\System\Seeder;

class PagesTableSeeder extends Seeder
{
    public function __construct()
    {
        $this->model = new Page();

        parent::__construct();
    }

    public function run($amount = 15)
    {
        foreach ([1, 2] as $accountid) {
            $account = Account::find($accountid);

            //flip array since array_rand returns the keys from an array

            for ($i = 0; $i < $amount; ++$i) {
                $page = $this->model->newInstance($this->texts());

                $page->user_id = 1;
                $page->account_id = $account->id;
                $page->save();

                $this->addImages($page);

                $this->subPages($page, $accountid);
            }
        }
    }

    protected function subPages($page, $accountid)
    {
        for ($i = 0; $i < 3; ++$i) {

            //let's just make a clone of the page and give it another title
            $subpage = $this->model->newInstance($this->texts());
            $subpage->user_id = $page->user_id;
            $subpage->parent_id = $page->id;
            $subpage->account_id = $accountid;

            $subpage->save();

            $this->addImages($subpage);
        }
    }

    protected function texts()
    {
        return [
            'nl' => [
                'title' => $this->nl->sentence(),
                'content' => $this->nl->realText(500),
                'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                'published' => rand(0, 1),
            ],
            'fr' => [
                'title' => $this->fr->sentence(),
                'content' => $this->fr->realText(500),
                'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                'published' => rand(0, 1),
            ],
            'en' => [
                'title' => $this->en->sentence(),
                'content' => $this->en->realText(500),
                'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                'published' => rand(0, 1),
            ],
            'de' => [
                'title' => $this->de->sentence(),
                'content' => $this->de->realText(500),
                'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                'published' => rand(0, 1),
            ],
        ];
    }
}
