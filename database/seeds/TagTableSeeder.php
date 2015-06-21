<?php

use App\Blog\Post;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Support\Collection;
use Jaffle\Tools\Seeder;
use App\Tags\Tag;

class TagTableSeeder extends Seeder
{

    use DispatchesCommands;

    public function run()
    {
        $tags = new Collection();

        for ($i = 0; $i < 15; $i++) {
            $tags->push(Tag::create([
                'nl' => [
                    'name' => $this->nl->word,
                ],
                'fr' => [
                    'name' => $this->fr->word,
                ],
                'en' => [
                    'name' => $this->en->word,
                ],
                'de' => [
                    'name' => $this->de->word,
                ]
            ]));
        }

        //mind the limit
        Post::limit(3)->chunk(300, function ($posts) use ($tags){

            foreach ($posts as $post) {

                $count = rand(1,3);
                $added = 0;

                while($added < $count)
                {
                    $post->tags()->save($tags->random());

                    $added++;
                }

            }
        });
    }
}