<?php namespace App\Blog\Presenter;

use App\Media\Image;
use App\Media\Shortcodes\MediaShortcodes;
use App\System\Presenter\BasePresenter;
use Markdown;

class PostFrontPresenter extends BasePresenter
{
    use MediaShortcodes;

    /**
     * Returns the entire post, fully loaded with shortcodes
     * Ready to be displayed onto your website.
     *
     * @return mixed
     */
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

    /**
     * The extract should not contain any style or media
     * It should simply be a text snippet.
     *
     * Therefor, at the end, we always strip all tags
     * We also strip out any shortcodes, which would only
     * inject either media or custom marked up content.
     *
     * @return string
     */
    public function extract()
    {
        $content = $this->entity->content;

        $content = $this->stripShortcodes($content);

        $content = Markdown::convertToHtml($content);

        $content = strip_tags($content);

        return $this->snippet($content);
    }

    protected function snippet($str, $wordCount = 60) {
        return implode(
            '',
            array_slice(
                preg_split(
                    '/([\s,\.;\?\!]+)/',
                    $str,
                    $wordCount*2+1,
                    PREG_SPLIT_DELIM_CAPTURE
                ),
                0,
                $wordCount*2-1
            )
        ) . '&nbsp;...';
    }

    protected function compileShortcodes($content)
    {
        $content = $this->compileMediaShortcodes($content);

        return $content;
    }

    protected function stripShortcodes($content)
    {
        return $this->stripMediaShortcodes($content);
    }

}