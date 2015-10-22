<?php namespace App\Pages\Jobs;

use App\Pages\Page;
use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdatePage extends Job implements SelfHandling{

    /**
     * @var Page
     */
    protected $page;

    /**
     * @var array
     */
    protected $input;

    public function __construct(Page $page, array $input)
    {
        $this->page = $page;
        $this->input = $input;
    }

    public function handle()
    {
        $this->page->fill($this->input);

        return $this->page->save() ? $this->page : false;
    }

}