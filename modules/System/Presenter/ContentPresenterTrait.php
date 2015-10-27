<?php namespace Modules\System\Presenter;

use Markdown;

trait ContentPresenterTrait
{
    /**
     * Returns the entire post, fully loaded with shortcodes
     * Ready to be displayed onto your website.
     *
     * @return mixed
     */
    public function content()
    {
        $content = $this->contentToPresent();

        //compile our custom shortcodes into valid markdown
        //take note, in our system provider,
        //we add the attributes extension to the
        //markdown environment.
        if(method_exists($this, 'compileShortCodes'))
        {
            $content = $this->compileShortcodes($content);
        }

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
    public function extract($chars = null)
    {
        $content = $this->contentToPresent();

        if(method_exists($this, 'stripShortCodes'))
        {
            $content = $this->stripShortcodes($content);
        }

        $content = $this->removeCodeSamples($content);

        $content = Markdown::convertToHtml($content);

        $content = strip_tags($content);

        return $this->snippet($content, 60, $chars);
    }

    protected function removeCodeSamples($content)
    {
        $content = preg_replace('/````(.|\s)*?````/', '', $content);

        return $content;
    }


    protected function snippet($str, $wordCount = 60, $chars = null) {

        $string = implode(
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
        );

        if(!empty($chars))
        {
            //oke, if the difference between chars and strlen is to high. we'd
            //be doing way to many while loops.
            //therefor, we will make sure that we first trim by hand to a reasonable strlen
            //in comparison to the allowed charlength.
            //if we get to close to the requested charlength, we might break words.
            //apparently, the average word length in english is 5.1 chars, so i guess
            //if we make our string max 13 chars longer, we wont break words in most occasions.

            $string = substr($string, 0, $chars + 13);

            while(strlen($string) > $chars){
                $string = preg_split(
                    '/([\s,\.;\?\!]+)/',
                    $string,
                    $wordCount*2+1,
                    PREG_SPLIT_DELIM_CAPTURE
                );

                do{
                    $piece = array_pop($string);
                }
                while(empty($piece));

                $string = implode('', $string);
            }
        }

        return $string  . '&nbsp;...';
    }

    /**
     * @return mixed
     */
    protected function contentToPresent()
    {
        if (property_exists($this, 'contentPresenterField')) {
            $content = $this->{$this->contentPresenterField};

            return $content;
        } else {
            $content = $this->entity->content;

            return $content;
        }
    }

}