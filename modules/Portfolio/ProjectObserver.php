<?php

namespace Modules\Portfolio;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Tags\Commands\UntagSomething;

/**
 * Class ProjectObserver
 * @package Modules\Portfolio
 */
class ProjectObserver
{
    use DispatchesJobs;

    /**
     * @param Project $project
     */
    public function deleting(Project $project)
    {
        $project->collaborators()->sync([]);

        foreach ($project->tags as $tag) {
            $this->dispatch(new UntagSomething($project, $tag));
        }

        $project->translations()->delete();

        foreach ($project->images as $image) {
            $image->delete();
        }
    }
}
