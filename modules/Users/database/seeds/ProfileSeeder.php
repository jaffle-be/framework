<?php

use Modules\System\Seeder;
use Modules\Users\Skill;
use Modules\Users\User;

/**
 * Class ProfileSeeder
 */
class ProfileSeeder extends Seeder
{
    public function run()
    {
        $this->profileInfo();
        $this->baseSkills();
    }

    protected function baseSkills()
    {
        $teller = 0;

        while ($teller < 10) {
            $skill = [
                'nl' => [
                    'name' => $this->nl->sentence(rand(1, 2), false),
                    'description' => $this->nl->paragraph(5),
                ],
                'fr' => [
                    'name' => $this->nl->sentence(rand(1, 2), false),
                    'description' => $this->nl->paragraph(5),
                ],
                'en' => [
                    'name' => $this->nl->sentence(rand(1, 2), false),
                    'description' => $this->nl->paragraph(5),
                ],
                'de' => [
                    'name' => $this->nl->sentence(rand(1, 2), false),
                    'description' => $this->nl->paragraph(5),
                ],

            ];

            Skill::create($skill);

            ++$teller;
        }

        $skills = array_flip([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

        foreach (User::all() as $user) {
            $user->skills()->sync(array_rand($skills, rand(3, 5)));
        }
    }

    protected function profileInfo()
    {
        foreach (User::all() as $user) {
            $user->fill([
                'nl' => [
                    'bio' => $this->nl->paragraph(6, true),
                    'quote' => $this->nl->sentence(8, true),
                    'quote_author' => $this->nl->name,
                ],
                'fr' => [
                    'bio' => $this->nl->paragraph(6, true),
                    'quote' => $this->nl->sentence(8, true),
                    'quote_author' => $this->nl->name,
                ],
                'en' => [
                    'bio' => $this->nl->paragraph(6, true),
                    'quote' => $this->nl->sentence(8, true),
                    'quote_author' => $this->nl->name,
                ],
                'de' => [
                    'bio' => $this->nl->paragraph(6, true),
                    'quote' => $this->nl->sentence(8, true),
                    'quote_author' => $this->nl->name,
                ],
            ]);

            $user->save();
        }
    }
}
