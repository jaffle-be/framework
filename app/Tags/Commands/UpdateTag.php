<?php namespace App\Tags\Commands;

use App\Commands\Command;
use App\Tags\Tag;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdateTag extends Command implements SelfHandling
{

    /**
     * @var Tag
     */
    protected $tag;

    /**
     * @var array
     */
    protected $input;

    /**
     * @param Tag   $tag
     * @param array $input
     */
    public function __construct(Tag $tag, array $input)
    {
        $this->tag = $tag;
        $this->input = $input;
    }

    /**
     * @return Tag|bool
     */
    public function handle()
    {
        foreach ($this->input['translations'] as $locale => $translations) {
            $translation = $this->tag->getTranslation($locale, false);

            if (!$translation) {
                $translation = $this->tag->getNewTranslation($locale);
            }

            $translation->fill($translations);
        }

        $this->tag->fill($this->input);

        $this->tag->save();

        return $this->tag->save() ? $this->tag : false;
    }
}