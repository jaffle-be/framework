<?php namespace Modules\Portfolio\Jobs;

use App\Jobs\Job;

use Modules\Portfolio\Project;

class UpdateProject extends Job
{

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