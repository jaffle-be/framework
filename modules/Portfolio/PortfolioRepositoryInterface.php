<?php

namespace Modules\Portfolio;

/**
 * Interface PortfolioRepositoryInterface
 * @package Modules\Portfolio
 */
interface PortfolioRepositoryInterface
{
    /**
     * @param int $limit
     * @return mixed
     */
    public function getExamples($limit = 4);
}
