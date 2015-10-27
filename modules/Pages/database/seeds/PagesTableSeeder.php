<?php

use Modules\Account\Account;
use Modules\Pages\Page;
use Modules\System\Seeder;

class PagesTableSeeder extends Seeder
{

    protected $image_names = [
        'BLOG_IMG_9908.jpg',
        'BLOG_IMG_9985.jpg',
        'BLOG_O14A0247.jpg',
        'BLOG_O14A0256.jpg',
        'BLOG_O14A0436.jpg',
    ];

    protected $prefix;

    protected $images;

    public function __construct(\Intervention\Image\ImageManager $images)
    {
        $this->images = $images;

        $this->model = new Page();

        $this->prefix = __DIR__ . '/../images/';

        parent::__construct();
    }

    public function run()
    {
        foreach([1] as $accountid)
        {
            $account = Account::find($accountid);

            //flip array since array_rand returns the keys from an array

            for ($i = 0; $i < 3; $i++) {

                $page = new Page($this->texts());

                $page->user_id = 1;
                $page->account_id = $account->id;
                $page->save();

                $counter = 0;
                $count = 2;

                while ($counter < $count) {
                    $this->newImage($page, $account);
                    $counter++;
                }

                $this->subPages($page, $accountid);

                echo 'page number ' . $i . PHP_EOL;
            }
        }
    }

    protected function subPages($page, $accountid)
    {
        for ($i = 0; $i < 3; $i++) {

            //let's just make a clone of the page and give it another title
            $subpage = new Page($this->texts());
            $subpage->user_id = $page->user_id;
            $subpage->parent_id = $page->id;
            $subpage->account_id = $accountid;

            $subpage->save();
        }

    }

    protected function texts()
    {
        return [
            'nl'      => [
                'title'      => $this->nl->sentence(),
                'content'    => $this->nl->realText(500),
                'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                'published' => rand(0,1),
            ],
            'fr'      => [
                'title'      => $this->fr->sentence(),
                'content'    => $this->fr->realText(500),
                'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                'published' => rand(0,1),
            ],
            'en'      => [
                'title'      => $this->en->sentence(),
                'content'    => $this->en->realText(500),
                'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                'published' => rand(0,1),
            ],
            'de'      => [
                'title'      => $this->de->sentence(),
                'content'    => $this->de->realText(500),
                'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                'published' => rand(0,1),
            ]
        ];
    }



}