<?php

namespace Modules\Portfolio;

class PortfolioRepository implements PortfolioRepositoryInterface
{

    /**
     * @var Project
     */
    protected $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function getExamples($limit = 4)
    {
        return $this->project->orderBy('date', 'desc')->take($limit)->get();
    }
}
