<?php

namespace Modules\Portfolio\Http;

use Modules\Portfolio\Project;
use Modules\Portfolio\ProjectTranslation;
use Modules\System\Http\FrontController;
use Modules\Tags\Tag;

class PortfolioController extends FrontController
{
    public function index(Project $project, Tag $tags)
    {
        $projects = $project->with($this->relations())->orderBy('date', 'desc')->get();

        $options = [
            'columns' => $this->theme->setting('portfolioColumns'),
            //grid or full width?
            'grid' => $this->theme->setting('portfolioGrid'),
            //space or no space?
            'spaced' => $this->theme->setting('portfolioSpaced'),
        ];

        $tags = $projects->getUniqueTags();

        return $this->theme->render('portfolio.index', ['projects' => $projects, 'options' => $options, 'tags' => $tags]);
    }

    public function show(ProjectTranslation $portfolio)
    {
        $relations = $this->relations();

        $project = $portfolio->project;

        if (! $project) {
            abort(404);
        }

        $project->load($relations);

        $this->seo->setEntity($project);

        $tags = $project->tags;

        $relatedProjects = $project->with($relations)
            ->taggedWith($tags)
            ->where($project->getTable().'.'.$project->getKeyName(), '<>', $project->id)
            ->orderBy($project->getTable().'.date', 'desc')
            ->take(4)
            ->get();

        if ($relatedProjects->count() < 4) {
            $extra = $project->with($relations)
                ->where($project->getTable().'.'.$project->getKeyName(), '<>', $project->id)
                ->orderBy($project->getTable().'.date', 'desc')
                ->take(4)
                ->get();

            while ($relatedProjects->count() < 4 && $extra->count() > 0) {
                $relatedProjects->push($extra->pop());
            }
        }

        return $this->theme->render('portfolio.show', ['project' => $project, 'relatedProjects' => $relatedProjects]);
    }

    /**
     * @return array
     */
    protected function relations()
    {
        return ['translations', 'images', 'images.translations', 'images.sizes', 'tags', 'tags.translations'];
    }
}
