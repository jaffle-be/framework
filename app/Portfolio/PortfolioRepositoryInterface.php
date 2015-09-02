<?php namespace App\Portfolio;

interface PortfolioRepositoryInterface
{

    public  function getExamples($limit = 4);

}