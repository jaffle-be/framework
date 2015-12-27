<?php

use Modules\Account\Account;
use Modules\Blog\Post;
use Modules\System\Seeder;

class BlogTableSeeder extends Seeder
{
    public function __construct()
    {
        $this->model = new Post();

        parent::__construct();
    }

    public function run($amount = 15)
    {
        foreach ([1, 2] as $accountid) {
            $account = Account::find($accountid);

            $tags = Modules\Tags\Tag::all();
            $tags = $tags->lists('id')->toArray();
            $tags = array_unique($tags);
            //flip array since array_rand returns the keys from an array
            $tags = array_flip($tags);

            for ($i = 0; $i < $amount; $i++) {
                $post = $this->model->newInstance($this->texts($accountid));

                $post->user_id = 1;
                $post->account_id = $account->id;
                $post->save();

                $this->addImages($post);

                $useTags = array_rand($tags, rand(1, 3));
                $useTags = (array) $useTags;
                $post->tags()->sync($useTags);
            }
        }
    }

    protected function texts($run)
    {
        return [
            'nl' => [
                'title'      => $this->nl->sentence(),
                'content'    => $this->nl->realText(500),
                'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                'publish_at' => rand(0, 1) ? $this->nl->dateTimeBetween('-1 months', '+3 months') : null,
            ],
            'fr' => [
                'title'      => $this->fr->sentence(),
                'content'    => $this->fr->realText(500),
                'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                'publish_at' => rand(0, 1) ? $this->nl->dateTimeBetween('-1 months', '+3 months') : null,
            ],
            'en' => [
                'title'      => $this->en->sentence(),
                'content'    => $this->en->realText(500),
                'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                'publish_at' => rand(0, 1) ? $this->nl->dateTimeBetween('-1 months', '+3 months') : null,
            ],
            'de' => [
                'title'      => $this->de->sentence(),
                'content'    => $this->de->realText(500),
                'created_at' => $this->nl->dateTimeBetween('-3 months', 'now'),
                'updated_at' => $this->nl->dateTimeBetween('-2 months', 'now'),
                'publish_at' => rand(0, 1) ? $this->nl->dateTimeBetween('-1 months', '+3 months') : null,
            ],
        ];
    }
}
