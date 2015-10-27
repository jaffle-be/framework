<?php namespace Modules\Portfolio;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Tags\Commands\UntagSomething;

class ProjectObserver
{
    use DispatchesJobs;

    public function deleting(Project $project)
    {
        $project->collaborators()->sync([]);

        foreach($project->tags as $tag)
        {
            $this->dispatchFromArray(UntagSomething::class, [
                'owner' => $project,
                'tag' => $tag,
            ]);
        }

        $project->translations()->delete();

        foreach($project->images as $image)
        {
            $image->delete();
        }
    }

}