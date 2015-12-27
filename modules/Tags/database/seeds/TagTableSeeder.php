<?php

use Modules\System\Seeder;
use Modules\Tags\Tag;

class TagTableSeeder extends Seeder
{
    public function run()
    {
        foreach ([1, 2] as $account) {
            $tags = ['Design', 'CMS', 'Copy', 'Branding', 'Tutorial', 'Business restructuring', 'Photography', 'Film', 'Analytics'];

            foreach ($tags as $tag) {
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
                    ],
                ]);
            }
        }
    }
}
