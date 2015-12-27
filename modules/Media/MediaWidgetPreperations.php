<?php

namespace Modules\Media;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

/**
 * Class MediaWidgetPreperations
 * @package Modules\Media
 */
trait MediaWidgetPreperations
{
    /**
     * @param Request $request
     * @return mixed
     */
    protected function owner(Request $request)
    {
        $id = $request->get('ownerId');
        $type = $request->get('ownerType');

        return $this->media->findOwner($type, $id);
    }

    /**
     * @param $owner
     * @param array $media
     */
    protected function prepareMedia($owner, array $media = ['images', 'infographics', 'videos', 'files'])
    {
        $valid = ['images', 'infographics', 'videos', 'files'];
        $media = array_intersect($valid, $media);

        foreach ($media as $type) {
            call_user_func_array([$this, 'prepare'.ucfirst($type)], [$owner]);
        }
    }

    /**
     * @param $owner
     */
    protected function prepareImages($owner)
    {
        $images = $owner->images;

        if ($images) {
            $images->load($this->MediaImageRelations());

            if (! $owner->mediaStoresMultiple()) {
                $images = new Collection([$images]);
            }
        }

        $owner->images = $images;
    }

    /**
     *
     */
    protected function mediaImageRelations()
    {
        return [
            'translations',
            'sizes' => function ($query) {
                $query->dimension(512);
            },
        ];
    }

    /**
     * @param $owner
     */
    protected function prepareInfographics($owner)
    {
        $owner->infographics;
    }

    /**
     * @param $owner
     */
    protected function prepareVideos($owner)
    {
        $owner->load('videos');
    }

    /**
     * @param $owner
     */
    protected function prepareFiles($owner)
    {
        $owner->load('files');
    }
}
