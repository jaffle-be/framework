<?php namespace App\Portfolio\Http;

use App\Portfolio\Project;
use App\System\Http\Controller;
use App\Tags\Tag;

class PortfolioController extends Controller
{

    public function index(Project $project, Tag $tags)
    {
        $projects = $project->with($this->relations())->orderBy('date', 'desc')->get();

        $options = [
            //grid or full width?
            'grid' => true,
            //space or no space?
            'spaced' => true,
            //with or without text
            'text' => true
        ];

        $tags = $tags->whereHas('projects', function($query){
            $query->whereNotNull('id');
        })->get();

        return $this->theme->render('portfolio.index', ['projects' => $projects, 'options' => $options, 'tags' => $tags]);
    }

    public function show(Project $portfolio)
    {
        $relations = $this->relations();

        $portfolio->load($relations);

        $relatedProjects = $portfolio->with($relations)
            ->where('id', '<>' , $portfolio->id)
            ->orderBy('date', 'desc')
            ->take(4)
            ->get();

        return $this->theme->render('portfolio.show', ['project' => $portfolio, 'relatedProjects' => $relatedProjects]);
    }

    /**
     * @return array
     */
    protected function relations()
    {
        return ['images', 'images.translations', 'images.sizes', 'tags', 'tags.translations'];
    }

}