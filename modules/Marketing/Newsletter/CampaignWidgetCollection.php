<?php

namespace Modules\Marketing\Newsletter;

use Illuminate\Database\Eloquent\Collection;
use Modules\Blog\Post;
use Modules\Portfolio\Project;

class CampaignWidgetCollection extends Collection
{

    public function setData()
    {
        list($posts, $projects) = $this->getMaps();

        $this->map(function ($widget) use ($posts, $projects) {

            if ($widget->resource_type) {
                if ($widget->resource_type == Post::class) {
                    $widget->resource = $posts->find($widget->resource_id);
                }

                if ($widget->resource_type == Project::class) {
                    $widget->resource = $projects->find($widget->resource_id);
                }
            }

            if ($widget->other_resource_type) {
                if ($widget->other_resource_type == Post::class) {
                    $widget->otherResource = $posts->find($widget->other_resource_id);
                }

                if ($widget->other_resource_type == Project::class) {
                    $widget->otherResource = $projects->find($widget->other_resource_id);
                }
            }

            return $widget;
        });
    }

    /**
     * the problem here is, that our polymorphic relations
     * aren't being loaded onto our data array.
     * so we need to set them manually at the end.
     *
     * @return array
     */
    public function toArray()
    {
        list($posts, $projects) = $this->getMaps();

        $data = parent::toArray();

        return array_map(function ($widget) use ($posts, $projects) {

            if ($widget['resource_type']) {
                if ($widget['resource_type'] == Post::class) {
                    $widget['resource'] = $posts->find($widget['resource_id'])->toArray();
                }

                if ($widget['resource_type'] == Project::class) {
                    $widget['resource'] = $projects->find($widget['resource_id'])->toArray();
                }
            }

            if ($widget['other_resource_type']) {
                if ($widget['other_resource_type'] == Post::class) {
                    $widget['otherResource'] = $posts->find($widget['other_resource_id'])->toArray();
                }

                if ($widget['other_resource_type'] == Project::class) {
                    $widget['otherResource'] = $projects->find($widget['other_resource_id'])->toArray();
                }
            }

            return $widget;
        }, $data);
    }

    /**
     * @return array
     * @internal param Campaign $newsletter
     */
    protected function getMaps()
    {
        $posts = new Collection();
        $projects = new Collection();

        $this->each(function ($widget) use ($projects, $posts) {

            if ($widget->resource) {
                if ($widget->resource_type == Post::class) {
                    $posts->push($widget->resource_id);
                }

                if ($widget->resource_type == Project::class) {
                    $projects->push($widget->resource_id);
                }
            }

            if ($widget->other_resource) {
                if ($widget->other_resource_type == Post::class) {
                    $posts->push($widget->other_resource_id);
                }

                if ($widget->other_resource_type == Project::class) {
                    $projects->push($widget->other_resource_id);
                }
            }
        });

        $posts = Post::whereIn('posts.id', $posts->all())->with(['translations', 'images', 'images.sizes'])->get();
        $projects = Project::whereIn('portfolio_projects.id', $projects->all())->with(['translations', 'images', 'images.sizes'])->get();

        return array($posts, $projects);
    }
}
