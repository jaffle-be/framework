<?php

namespace Modules\Tags\Http;

use Modules\System\Http\FrontController;
use Modules\Tags\Tag;

class TagsController extends FrontController
{

    public function show(Tag $tag)
    {
        $content = $tag->content;

        $content->load('taggable');

        return $this->theme->render('tags.show', ['tag' => $tag]);
    }
}
