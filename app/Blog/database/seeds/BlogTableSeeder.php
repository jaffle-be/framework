<?php

use App\Account\Account;
use App\Blog\Post;
use App\Media\Commands\StoreNewImage;
use App\Media\ImageDimensionHelpers;
use App\System\Seeder;
use Illuminate\Foundation\Bus\DispatchesCommands;

class BlogTableSeeder extends Seeder
{

    use DispatchesCommands;
    use ImageDimensionHelpers;

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

        $this->image_sizes = config('media.sizes.blog');;

        $this->prefix = __DIR__ . '/../images/';

        parent::__construct();
    }

    public function run()
    {
        \DB::connection()->disableQueryLog();
        $account = Account::find(1);

        $this->preImageCaching();

        $tags = App\Tags\Tag::all();
        $tags = $tags->lists('id')->toArray();
        $tags = array_unique($tags);
        //flip array since array_rand returns the keys from an array
        $tags = array_flip($tags);

        for ($i = 0; $i < 40; $i++) {

            $post = new Post([
                'slug_nl' => str_slug($this->nl->sentence() . rand(0, 1000000)),
                'slug_fr' => str_slug($this->fr->sentence() . rand(0, 1000000)),
                'slug_en' => str_slug($this->en->sentence() . rand(0, 1000000)),
                'slug_de' => str_slug($this->de->sentence() . rand(0, 1000000)),
                'nl'      => [
                    'title'      => $this->nl->sentence(),
                    'extract'    => $this->nl->realText(100),
                    'content'    => $this->nl->realText(500),
                    'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                    'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                    'publish_at' => $this->nl->dateTimeBetween('-1 months', '+3 months')
                ],
                'fr'      => [
                    'title'      => $this->fr->sentence(),
                    'extract'    => $this->fr->realText(100),
                    'content'    => $this->fr->realText(500),
                    'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                    'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                    'publish_at' => $this->nl->dateTimeBetween('-1 months', '+3 months')
                ],
                'en'      => [
                    'title'      => $this->en->sentence(),
                    'extract'    => $this->en->realText(100),
                    'content'    => $this->en->realText(500),
                    'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                    'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                    'publish_at' => $this->nl->dateTimeBetween('-1 months', '+3 months')
                ],
                'de'      => [
                    'title'      => $this->de->sentence(),
                    'extract'    => $this->de->realText(100),
                    'content'    => $this->de->realText(500),
                    'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                    'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                    'publish_at' => $this->nl->dateTimeBetween('-1 months', '+3 months')
                ]
            ]);

            $post->user_id = 1;
            $post->account_id = 1;
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

    protected function newImage($post, $account)
    {
        $image = rand(0, count($this->image_names) - 1);

        $this->dispatchFromArray(StoreNewImage::class, [
            'account' => $account,
            'owner'   => $post,
            'path'    => $this->prefix . $this->image_names[$image],
            'sizes'   => $this->image_sizes,
            'seeding' => true
        ]);
    }

    /**
     * @param $images
     * @param $sizes
     *
     * @return mixed
     */
    protected function preImageCaching()
    {
        //run images cachings.
        foreach ($this->image_names as $image) {

            $path = $this->prefix . $image;

            foreach ($this->image_sizes as $size) {

                list($width, $height) = $this->dimensions($size);

                $constraint = $this->constraint($width, $height);

                $this->images->cache(function ($image) use ($path, $width, $height, $constraint) {
                    $image->make($path)->resize($width, $height, $constraint);
                });
            }
        }
    }
}