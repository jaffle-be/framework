<?php

namespace Modules\Media\Shortcodes;

use Modules\Media\Image;

trait MediaShortcodes
{
    protected function compileMediaShortcodes($content)
    {
        $content = $this->compileImageShortcode($content);

        $content = $this->compileVideoShortcode($content);

        $content = $this->compileInfographicShortcode($content);

        $content = $this->compileFileShortcode($content);

        return $content;
    }

    protected function compileImageShortcode($content)
    {
        $images = $this->getWantedImages($content);

        foreach ($images as $image) {
            $content = $this->addImage($content, $image);
        }

        return $content;
    }

    /**
     * Return a sorted array with all requested images.
     *
     * @param $content
     */
    protected function getWantedImages($content)
    {
        preg_match_all('/#image(:left|:right)?#/', $content, $matches);

        list($full, $alignment) = $matches;

        $images = [];

        foreach ($full as $key => $pattern) {
            $float = $alignment[$key];

            $images[] = [
                //always leave the first image for blog page detail layout
                //to use it
                'counter' => $key + 1,
                'pattern' => $pattern,
                'float' => str_replace(':', '.pull-', $float),
            ];
        }

        return $images;
    }

    /**
     * Replace the image placeholder with the actual html + markdown combination
     * to support decently placed images throughout our text. While still disabling
     * other customisations through html/css. We want our content to adhere to the
     * styles provided per account. No need to allow a client to mess around.
     *
     * @param $content
     * @param $image
     */
    protected function addImage(&$content, $image)
    {
        $img = $this->images->get($image['counter']);

        //make sure to remove the tag by default.
        $replacement = '';

        if ($markdown = $this->getMarkdownForImage($img, $image)) {
            $replacement = $markdown;
        }

        $content = str_replace($image['pattern'], $replacement, $content);

        return $content;
    }

    protected function getMarkdownForImage(Image $img = null, array $placement)
    {
        //we want to support the following image inclusions:
        //#image# -> default to full-width implementation
        //#image:left#
        //#image:right#

        if (!$img) {
            return false;
        }

        $title = $img->title ?: 'image_'.$placement['counter'];

        if (!$float = $placement['float']) {
            return $this->handleFullWidth($title, $this->imageLink($img, true));
        } else {
            return $this->handleFloat($title, $this->imageLink($img, false), $float);
        }
    }

    /**
     * the full-width in front will make sure that the surrounding <p> tag has the full-width class.
     * if your image is still not full-width, you should change the css of the appropriate parents
     * in most cases this simply means: don't add padding to the element containing the entire post
     * you should instead add the padding or margin to the content related tags within that container.
     *
     * @param $title
     * @param $link
     *
     * @return string
     */
    protected function handleFullWidth($title, $link)
    {
        return sprintf('{.full-width.blog-img}'.PHP_EOL.'![%s](%s){.img-responsive.full-width}', $title, $link);
    }

    /**
     * @param Image $img
     * @param bool  $big
     *
     * @return string
     */
    protected function imageLink(Image $img, $big)
    {
        $path = $big ? $img->path : $img->thumbnail(460);

        return asset($path);
    }

    /**
     * This one simply pulls an images left or right.
     * If it's not being pulled, make sure the path that's being used,
     * is a path that references an image which is smaller then the viewport.
     * If not, it would simply just take up the full width due to .img-responsive.
     *
     * @param $title
     * @param $link
     * @param $float
     *
     * @return string
     */
    protected function handleFloat($title, $link, $float)
    {
        //this should be improved to force fullwidth on mobile.
        //or at least responsiveness should be improved.
        //since like this, content will get unreadable on certain screens
        //since its smashed in a narrow area next to the image
        //the image should probably only actually float when we're on a @screen-lg?
        return sprintf('{.clearfix}'.PHP_EOL.'![%s](%s){.img-responsive%s}', $title, $link, $float);
    }

    protected function compileVideoShortcode($content)
    {
        $count = $this->getWantedVideos($content);

        $counter = 0;

        while ($counter < $count) {
            $replacement = '';

            if ($video = $this->videos->get($counter)) {
                $replacement = '<figure class="responsive-video">'.$video->embed.'</figure>';
            }

            $content = preg_replace('/#video#/', $replacement, $content, 1);

            ++$counter;
        }

        return $content;
    }

    protected function getWantedVideos($content)
    {
        preg_match_all('/#video#/', $content, $matches);

        return count($matches[0]);
    }

    protected function compileInfographicShortcode($content)
    {
        $count = $this->getWantedInfographics($content);

        $counter = 0;

        while ($counter < $count) {
            $replacement = '';

            if ($infographic = $this->infographics->get($counter)) {
                $replacement = $this->handleFullWidth($infographic->title, asset($infographic->path));
            }

            $content = preg_replace('/#infographic#/', $replacement, $content, 1);

            ++$counter;
        }

        return $content;
    }

    /**
     * Return a sorted array with all requested images.
     *
     * @param $content
     *
     * @return int
     */
    protected function getWantedInfographics($content)
    {
        preg_match_all('/#infographic#/', $content, $matches);

        return count($matches[0]);
    }

    protected function compileFileShortcode($content)
    {
        $count = $this->getWantedFiles($content);

        $counter = 0;

        while ($counter < $count) {
            $replacement = '';

            if ($file = $this->files->get($counter)) {
                $replacement = sprintf('[%s](%s)', $file->title ?: $file->filename, asset($file->path));
            }

            $content = preg_replace('/#file#/', $replacement, $content, 1);

            ++$counter;
        }

        return $content;
    }

    /**
     * Return a sorted array with all requested images.
     *
     * @param $content
     *
     * @return int
     */
    protected function getWantedFiles($content)
    {
        preg_match_all('/#file#/', $content, $matches);

        return count($matches[0]);
    }

    protected function stripMediaShortcodes($content)
    {
        $content = preg_replace('/#image(:left|:right)?#/', '', $content);

        $content = preg_replace('/#video#/', '', $content);

        $content = preg_replace('/#infographic#/', '', $content);

        $content = preg_replace('/#file#/', '', $content);

        return $content;
    }

    protected function formatMediaShortcodes($content)
    {
        $content = preg_replace('/(.*)(#image(:left|:right)?#)(.*)/', "$1\n$2\n$4", $content);

        $content = preg_replace('/(.*)#video#(.*)/', "$1\n#video#\n$2", $content);

        $content = preg_replace('/(.*)#infographic#(.*)/', "$1\n#infographic#\n$2", $content);

        $content = preg_replace('/(.*)#file#(.*)/', "$1\n#file#\n$2", $content);

        return $content;
    }
}
