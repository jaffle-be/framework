<?php

use App\System\Seeder;
use App\Tags\Tag;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Support\Collection;

class TagTableSeeder extends Seeder
{

    use DispatchesCommands;

    public function run()
    {
        foreach([1,2] as $account)
        {
            $tags = ['Design', 'CMS', 'Copy', 'Branding', 'Tutorial', 'Business restructuring', 'Photography', 'Film', 'Analytics'];

            foreach($tags as $tag)
            {
                Tag::create([
                    'account_id' => $account,
                    'nl' => [
                        'name' => $tag,
                    ],
                    'fr' => [
                        'name' => $tag,
                    ],
                    'en' => [
                        'name' => $tag,
                    ],
                    'de' => [
                        'name' => $tag,
                    ]
                ]);
            }
        }

    }
}