<?php namespace App\Media\Video;

trait VideoGenericFormatter
{

    protected function vimeoReponse($body)
    {
        $me = $this;

        return array_map(function ($video) use ($me) {

            return $me->vimeoVideoResponse($video);
        }, $body->data);
    }

    protected function vimeoVideoResponse($video)
    {
        if(!is_object($video))
        {
            $video = json_decode(json_encode($video));
        }

        $pictures = $video->pictures->sizes;
        $picture = array_pop($pictures);

        return [
            'provider'           => 'vimeo',
            'provider_id'        => str_replace('/videos/', '', $video->uri),
            'provider_thumbnail' => $picture->link,
            'title'              => $video->name,
            'description'        => $video->description,
            'width'              => $video->width,
            'height'             => $video->height,
            'publishedAt'        => $video->created_time,
        ];
    }

    protected function youtubeResponse($response)
    {
        $me = $this;

        return array_map(function ($video) use ($me) {

            return $me->youtubeVideoResponse($video);
        }, $response);
    }

    protected function youtubeVideoResponse($video)
    {
        list($width, $height) = $this->parseYoutubeVideoDimensions($video);
        return [
            'provider'           => 'youtube',
            //if the video comes from video by id, the id won't be an object like in the search function
            'provider_id'        => is_object($video->id) ? $video->id->videoId : $video->id,
            'provider_thumbnail' => isset($video->snippet->thumbnails->maxres) ? $video->snippet->thumbnails->maxres->url : $video->snippet->thumbnails->high->url,
            'title'              => $video->snippet->title,
            'description'        => $video->snippet->description,
            'width'              => $width,
            'height'             => $height,
            'publishedAt'        => $video->snippet->publishedAt,
        ];
    }

    protected function parseYoutubeVideoDimensions($video)
    {
        if(isset($video->player))
        {
            preg_match('/width="(\d+)"/', $video->player->embedHtml, $widths);
            preg_match('/height="(\d+)"/', $video->player->embedHtml, $heights);

            return [$widths[1], $heights[1]];
        }

        return [null, null];
    }

}