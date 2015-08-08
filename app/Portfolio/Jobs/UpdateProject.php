<?php namespace App\Portfolio\Jobs;

use App\Jobs\Job;
use App\Portfolio\Project;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdateProject extends Job implements SelfHandling{

    /**
     * @var Project
     */
    protected $project;

    /**
     * @var array
     */
    protected $input;

    public function __construct(Project $project, array $input)
    {
        $this->project = $project;
        $this->input = $input;
    }

    public function handle()
    {
        $this->project->fill($this->input);

        return $this->project->save() ? $this->project : false;
    }

}