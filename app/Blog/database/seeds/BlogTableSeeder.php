<?php

use App\Account\Account;
use App\Blog\Post;
use App\System\Seeder;

class BlogTableSeeder extends Seeder
{

    protected $image_names = [
        'BLOG_IMG_9908.jpg',
        'BLOG_IMG_9985.jpg',
        'BLOG_O14A0247.jpg',
        'BLOG_O14A0256.jpg',
        'BLOG_O14A0436.jpg',
    ];

    protected $image_sizes = [];

    protected $prefix;

    protected $images;

    public function __construct(\Intervention\Image\ImageManager $images)
    {
        $this->images = $images;

        $this->image_sizes = config('media.sizes.blog');

        $this->prefix = __DIR__ . '/../images/';

        parent::__construct();
    }

    public function run()
    {
        foreach([1,2] as $accountid)
        {
            $account = Account::find($accountid);

            $this->preImageCaching();

            $tags = App\Tags\Tag::all();
            $tags = $tags->lists('id')->toArray();
            $tags = array_unique($tags);
            //flip array since array_rand returns the keys from an array
            $tags = array_flip($tags);

            for ($i = 0; $i < 40; $i++) {

                $payload = array_merge([
                    'slug_nl' => str_slug($this->nl->sentence() . rand(0, 1000000)),
                    'slug_fr' => str_slug($this->fr->sentence() . rand(0, 1000000)),
                    'slug_en' => str_slug($this->en->sentence() . rand(0, 1000000)),
                    'slug_de' => str_slug($this->de->sentence() . rand(0, 1000000)),

                ], $this->texts($accountid));

                $post = new Post($payload);

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
        if($run > 1)
        {
            return [
                'nl'      => [
                    'title'      => 'a smaller sentence',
                    'extract'    => 'some stupid random text the same for each non digiredo account. some stupid random text the same for each non digiredo account. some stupid random text the same for each non digiredo account. some stupid random text the same for each non digiredo account.some stupid random text the same for each non digiredo account',
                    'content'    => 'some stupid random text the same for each non digiredo account. some stupid random text the same for each non digiredo account. some stupid random text the same for each non digiredo account. some stupid random text the same for each non digiredo account.some stupid random text the same for each non digiredo account',
                    'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                    'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                    'publish_at' => rand(0,1)  ? $this->nl->dateTimeBetween('-1 months', '+3 months') : null,
                ],
                'fr'      => [
                    'title'      => 'a smaller sentence',
                    'extract'    => 'some stupid random text the same for each non digiredo account. some stupid random text the same for each non digiredo account. some stupid random text the same for each non digiredo account. some stupid random text the same for each non digiredo account.some stupid random text the same for each non digiredo account',
                    'content'    => 'some stupid random text the same for each non digiredo account. some stupid random text the same for each non digiredo account. some stupid random text the same for each non digiredo account. some stupid random text the same for each non digiredo account.some stupid random text the same for each non digiredo account',
                    'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                    'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                    'publish_at' => rand(0,1)  ? $this->nl->dateTimeBetween('-1 months', '+3 months') : null,
                ],
                'en'      => [
                    'title'      => 'a smaller sentence',
                    'extract'    => 'some stupid random text the same for each non digiredo account. some stupid random text the same for each non digiredo account. some stupid random text the same for each non digiredo account. some stupid random text the same for each non digiredo account.some stupid random text the same for each non digiredo account',
                    'content'    => 'some stupid random text the same for each non digiredo account. some stupid random text the same for each non digiredo account. some stupid random text the same for each non digiredo account. some stupid random text the same for each non digiredo account.some stupid random text the same for each non digiredo account',
                    'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                    'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                    'publish_at' => rand(0,1)  ? $this->nl->dateTimeBetween('-1 months', '+3 months') : null,
                ],
                'de'      => [
                    'title'      => 'a smaller sentence',
                    'extract'    => 'some stupid random text the same for each non digiredo account. some stupid random text the same for each non digiredo account. some stupid random text the same for each non digiredo account. some stupid random text the same for each non digiredo account.some stupid random text the same for each non digiredo account',
                    'content'    => 'some stupid random text the same for each non digiredo account. some stupid random text the same for each non digiredo account. some stupid random text the same for each non digiredo account. some stupid random text the same for each non digiredo account.some stupid random text the same for each non digiredo account',
                    'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                    'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                    'publish_at' => rand(0,1)  ? $this->nl->dateTimeBetween('-1 months', '+3 months') : null,
                ]
            ];
        }

        return [
            'nl'      => [
                'title'      => $this->nl->sentence(),
                'extract'    => $this->nl->realText(100),
                'content'    => $this->nl->realText(500),
                'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                'publish_at' => rand(0,1)  ? $this->nl->dateTimeBetween('-1 months', '+3 months') : null,
            ],
            'fr'      => [
                'title'      => $this->fr->sentence(),
                'extract'    => $this->fr->realText(100),
                'content'    => $this->fr->realText(500),
                'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                'publish_at' => rand(0,1)  ? $this->nl->dateTimeBetween('-1 months', '+3 months') : null,
            ],
            'en'      => [
                'title'      => $this->en->sentence(),
                'extract'    => $this->en->realText(100),
                'content'    => $this->en->realText(500),
                'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                'publish_at' => rand(0,1)  ? $this->nl->dateTimeBetween('-1 months', '+3 months') : null,
            ],
            'de'      => [
                'title'      => $this->de->sentence(),
                'extract'    => $this->de->realText(100),
                'content'    => $this->de->realText(500),
                'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                'publish_at' => rand(0,1)  ? $this->nl->dateTimeBetween('-1 months', '+3 months') : null,
            ]
        ];
    }



}