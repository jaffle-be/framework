<?php

use Modules\Account\Account;
use Modules\Account\Client;
use Modules\Portfolio\Project;
use Modules\System\Seeder;
use Modules\Tags\Tag;
use Modules\Users\User;

class PortfolioTableSeeder extends Seeder
{
    public function __construct()
    {
        $this->model = new Project();

        parent::__construct();
    }

    public function run($creating = 15)
    {
        foreach ([1, 2] as $accountid) {
            $account = Account::find($accountid);
            $clients = Client::all();

            $users = User::all();
            $users = $users->lists('id')->toArray();
            //flip so we can use array_rand
            $tags = array_flip(Tag::lists('id')->toArray());

            for ($i = 0; $i < $creating; $i++) {
                $project = Modules\Portfolio\Project::create([
                    'account_id' => $account->id,
                    'date'       => $this->nl->dateTimeBetween('-3 months', 'now'),
                    'website'    => $this->nl->url,
                    'nl'         => [
                        'published'  => rand(0, 1),
                        'title'      => $this->nl->sentence(2),
                        'content'    => $this->nl->text(1300),
                        'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                        'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                    ],
                    'fr'         => [
                        'published'  => rand(0, 1),
                        'title'      => $this->fr->sentence(2),
                        'content'    => $this->fr->text(1300),
                        'created_at' => $this->fr->dateTimeBetween('-3 months', 'now'),
                        'updated_at' => $this->fr->dateTimeBetween('-2 months', 'now'),
                    ],
                    'en'         => [
                        'published'  => rand(0, 1),
                        'title'      => $this->en->sentence(2),
                        'content'    => $this->en->text(1300),
                        'created_at' => $this->en->dateTimeBetween('-3 months', 'now'),
                        'updated_at' => $this->en->dateTimeBetween('-2 months', 'now'),
                    ],
                    'de'         => [
                        'published'  => rand(0, 1),
                        'title'      => $this->de->sentence(2),
                        'content'    => $this->de->text(1300),
                        'created_at' => $this->de->dateTimeBetween('-3 months', 'now'),
                        'updated_at' => $this->de->dateTimeBetween('-2 months', 'now'),
                    ],
                ]);

                $this->addImages($project);

                //foreach project we randomly add 1 to 3 collaborators
                $amount = rand(1, 3);
                $possibleUsers = $users;

                for ($j = 0; $j < $amount; $j++) {
                    shuffle($possibleUsers);

                    $add = array_shift($possibleUsers);

                    $project->collaborators()->attach($add);
                }

                $project->tags()->sync(array_rand($tags, 2));

                $project->client()->associate($clients->random());

                $project->save();
            }
        }
    }
}
