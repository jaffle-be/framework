<?php

namespace Modules\Portfolio;

/**
 * Class PortfolioRepository
 * @package Modules\Portfolio
 */
class PortfolioRepository implements PortfolioRepositoryInterface
{
    /**
     * @var Project
     */
    protected $project;

    /**
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getExamples($limit = 4)
    {
        return $this->project->orderBy('date', 'desc')->take($limit)->get();
    }
}
