<?php

use Modules\Account\Account;
use Modules\Blog\Post;
use Modules\System\Seeder;

class BlogTableSeeder extends Seeder
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

        $this->model = new Post();

        $this->prefix = __DIR__ . '/../images/';

        parent::__construct();
    }

    public function run()
    {
        foreach([1] as $accountid)
        {
            $account = Account::find($accountid);

            $tags = Modules\Tags\Tag::all();
            $tags = $tags->lists('id')->toArray();
            $tags = array_unique($tags);
            //flip array since array_rand returns the keys from an array
            $tags = array_flip($tags);

            for ($i = 0; $i < 15; $i++) {

                $post = new Post($this->texts($accountid));

                $post->user_id = 1;
                $post->account_id = $account->id;
                $post->save();

                $counter = 0;

                if ($counter < 5) {
                    $count = 2;
                } else {
                    $count = 1;
                }

                while ($counter < $count) {
                    $this->newImage($post, $account);
                    $counter++;
                }

                $useTags = array_rand($tags, rand(1, 3));
                $useTags = (array)$useTags;
                $post->tags()->sync($useTags);

                echo 'post number ' . $i . PHP_EOL;
            }
        }
    }

    protected function texts($run)
    {
        return [
            'nl'      => [
                'title'      => $this->nl->sentence(),
                'content'    => $this->nl->realText(500),
                'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                'publish_at' => rand(0,1)  ? $this->nl->dateTimeBetween('-1 months', '+3 months') : null,
            ],
            'fr'      => [
                'title'      => $this->fr->sentence(),
                'content'    => $this->fr->realText(500),
                'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                'publish_at' => rand(0,1)  ? $this->nl->dateTimeBetween('-1 months', '+3 months') : null,
            ],
            'en'      => [
                'title'      => $this->en->sentence(),
                'content'    => $this->en->realText(500),
                'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                'publish_at' => rand(0,1)  ? $this->nl->dateTimeBetween('-1 months', '+3 months') : null,
            ],
            'de'      => [
                'title'      => $this->de->sentence(),
                'content'    => $this->de->realText(500),
                'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                'publish_at' => rand(0,1)  ? $this->nl->dateTimeBetween('-1 months', '+3 months') : null,
            ]
        ];
    }



}