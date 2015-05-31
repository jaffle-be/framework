<?php

use App\Blog\Post;
use App\Blog\PostTranslation;
use App\Media\Commands\StoreNewImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Jaffle\Tools\Seeder;

class BlogTableSeeder extends Seeder
{

    use DispatchesCommands;

    public function run()
    {
        Post::unguard();
        PostTranslation::unguard();

        for ($i = 0; $i < 100; $i++) {
            $post = App\Blog\Post::create([
                'user_id' => 1,
                'nl' => [
                    'title' => $this->nl->sentence(),
                    'extract' => $this->nl->realText(100),
                    'content' => $this->nl->realText(500),
                    'user_id' => 1,
                    'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                    'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                    'publish_at' => $this->nl->dateTimeBetween('-1 months', '+3 months')
                ],
                'fr' => [
                    'title' => $this->fr->sentence(),
                    'extract' => $this->fr->realText(100),
                    'content' => $this->fr->realText(500),
                    'user_id' => 1,
                    'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                    'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                    'publish_at' => $this->nl->dateTimeBetween('-1 months', '+3 months')
                ],
                'en' => [
                    'title' => $this->en->sentence(),
                    'extract' => $this->en->realText(100),
                    'content' => $this->en->realText(500),
                    'user_id' => 1,
                    'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                    'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                    'publish_at' => $this->nl->dateTimeBetween('-1 months', '+3 months')
                ],
                'de' => [
                    'title' => $this->de->sentence(),
                    'extract' => $this->de->realText(100),
                    'content' => $this->de->realText(500),
                    'user_id' => 1,
                    'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                    'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                    'publish_at' => $this->nl->dateTimeBetween('-1 months', '+3 months')
                ]
            ]);


            $count = rand(1,3);
            $teller = 0;

            while($teller < $count)
            {
                $this->newImage($post);
                $teller++;
            }

        }
    }

    protected function newImage($post)
    {
        $images = [
            'IMG_9908.jpg',
            'IMG_9985.jpg',
            'O14A0241.jpg',
            'O14A0247.jpg',
            'O14A0256.jpg',
            'O14A0436.jpg',
            'O14A0438.jpg',
        ];

        $image = rand(0, count($images) - 1);

        $this->dispatchFromArray(StoreNewImage::class, [
            'owner' => $post,
            'path' => __DIR__ . '/../images/' . $images[$image],
            'sizes' => config('blog.image_sizes')
        ]);
    }
}