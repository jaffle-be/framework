<?php namespace App\Blog\Presenter;

use App\Media\Image;
use App\System\Presenter\BasePresenter;
use Markdown;

class PostFrontPresenter extends BasePresenter
{

    public function content()
    {
        $content = $this->entity->content;

        //compile our custom shortcodes into valid markdown
        //take note, in our system provider,
        //we add the attributes extension to the
        //markdown environment.
        $content = $this->compileShortcodes($content);

        return Markdown::convertToHtml($content);
    }

    protected function compileShortcodes($content)
    {
        $content = $this->compileImageShortcode($content);

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
     *
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
                'float'   => str_replace(':', '.pull-', $float)
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

        $title = $img->title ?: 'image_' . $placement['counter'];

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
        return sprintf('{.full-width}' . PHP_EOL . '![%s](%s){.img-responsive.full-width}', $title, $link);
    }

    /**
     * This one simply pulls an images left or right.
     * If it's not being pulled, make sure the path that's being used,
     * is a path that references an image which is smaller then the viewport.
     * If not, it would simply just take up the full width due to .img-responsive
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
        return sprintf('{.clearfix}' . PHP_EOL . '![%s](%s){.img-responsive%s}', $title, $link, $float);
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

}