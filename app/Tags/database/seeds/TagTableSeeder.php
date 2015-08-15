<?php

use App\Tags\Tag;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Support\Collection;
use Jaffle\Tools\Seeder;

class TagTableSeeder extends Seeder
{

    use DispatchesCommands;

    public function run()
    {
        $tags = new Collection();

        for ($i = 0; $i < 15; $i++) {
            $tags->push(Tag::create([
                'account_id' => 1,
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
    }
}