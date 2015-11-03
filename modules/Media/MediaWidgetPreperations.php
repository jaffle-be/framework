<?php namespace Modules\Media;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

trait MediaWidgetPreperations
{

    protected function owner(Request $request)
    {
        $id = $request->get('ownerId');
        $type = $request->get('ownerType');

        return $this->media->findOwner($type, $id);
    }

    protected function prepareMedia($owner, $media)
    {
        $this->prepareImages($owner);
        $this->prepareInfographics($owner);
        $this->prepareVideos($owner);
        $this->prepareFiles($owner);
    }

    /**
     * @param $owner
     *
     * @return Collection
     */
    protected function prepareImages($owner)
    {
        $images = $owner->images;

        if ($images) {
            $images->load($this->MediaImageRelations());

            if (!$owner->mediaStoresMultiple()) {
                $images = new Collection([$images]);
            }
        }

        $owner->images = $images;
    }

    /**
     * @return array
     */
    protected function mediaImageRelations()
    {
        return [
            'translations',
            'sizes' => function ($query) {
                $query->dimension(512);
            }
        ];
    }

    /**
     * @param $owner
     *
     * @return mixed
     */
    protected function prepareInfographics($owner)
    {
        $owner->infographics;
    }

    protected function prepareVideos($owner)
    {
        $owner->load('videos');
    }

    protected function prepareFiles($owner)
    {
        $owner->load('files');
    }



}