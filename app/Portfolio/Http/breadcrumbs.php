<?php

use App\Portfolio\Project;

Breadcrumbs::register('store.portfolio.index', function($breadcrumbs){
    $breadcrumbs->parent('store.home');
    $breadcrumbs->push('Projects', route('store.portfolio.index'));
});


Breadcrumbs::register('store.portfolio.show', function($breadcrumbs, Project $project){
    $breadcrumbs->parent('store.portfolio.index');
    $breadcrumbs->push($project->title, route('store.portfolio.index'));
});