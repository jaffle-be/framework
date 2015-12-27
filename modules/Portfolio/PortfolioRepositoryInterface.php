<?php

namespace Modules\Portfolio;

interface PortfolioRepositoryInterface
{

    public function getExamples($limit = 4);
}
