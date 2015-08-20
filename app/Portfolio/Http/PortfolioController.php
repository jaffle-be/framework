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
            'columns' => $this->theme->setting('portfolioColumns'),
            //grid or full width?
            'grid'    => $this->theme->setting('portfolioGrid'),
            //space or no space?
            'spaced'  => $this->theme->setting('portfolioSpaced'),
        ];

        $tags = $projects->getUniqueTags();

        return $this->theme->render('portfolio.index', ['projects' => $projects, 'options' => $options, 'tags' => $tags]);
    }

    public function show(Project $portfolio)
    {
        $relations = $this->relations();

        $portfolio->load($relations);

        $tags = $portfolio->tags;

        $relatedProjects = $portfolio->with($relations)
            ->whereHas('tags', function ($query) use ($tags) {
                $query->whereIn('id', $tags->lists('id')->toArray());
            })
            ->where('id', '<>', $portfolio->id)
            ->orderBy('date', 'desc')
            ->take(4)
            ->get();

        if ($relatedProjects->count() < 4) {
            $extra = $portfolio->with($relations)
                ->where('id', '<>', $portfolio->id)
                ->orderBy('date', 'desc')
                ->take(4)
                ->get();

            while ($relatedProjects->count() < 4 && $extra->count() > 0) {
                $relatedProjects->push($extra->pop());
            }
        }

        return $this->theme->render('portfolio.show', ['project' => $portfolio, 'relatedProjects' => $relatedProjects]);
    }

    /**
     * @return array
     */
    protected function relations()
    {
        return ['translations', 'images', 'images.translations', 'images.sizes', 'tags', 'tags.translations'];
    }

}