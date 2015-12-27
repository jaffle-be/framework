<?php

namespace Modules\Tags\Http;

use Modules\System\Http\FrontController;
use Modules\Tags\Tag;

/**
 * Class TagsController
 * @package Modules\Tags\Http
 */
class TagsController extends FrontController
{
    /**
     * @param Tag $tag
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Tag $tag)
    {
        $content = $tag->content;

        $content->load('taggable');

        return $this->theme->render('tags.show', ['tag' => $tag]);
    }
}
