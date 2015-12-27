<?php namespace Modules\Pages\Jobs;

use App\Jobs\Job;

use Modules\Pages\Page;

class UpdatePage extends Job
{

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