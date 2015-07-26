<?php namespace App\Tags\Commands;

use App\Jobs\Job;
use App\Tags\Tag;
use Illuminate\Contracts\Bus\SelfHandling;

class CreateNewTag extends Job implements SelfHandling
{

    protected $locale;

    protected $name;

    public function __construct($locale, $name)
    {
        $this->locale = $locale;
        $this->name = $name;
    }

    public function handle(Tag $tag)
    {
        $payload = [
            $this->locale => [
                'name' => $this->name
            ]
        ];

        $tag = $tag->create($payload);

        return $tag ? : false;
    }
}