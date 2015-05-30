<?php

use App\Blog\Post;
use App\Blog\PostTranslation;
use Illuminate\Database\Eloquent\Model;
use Jaffle\Tools\Seeder;

class BlogTableSeeder extends Seeder
{

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

        }
    }
}