<?php namespace App\Tags\Http;

use App;
use App\Account\AccountManager;
use App\System\Http\FrontController;
use App\Tags\Tag;

class TagsController extends FrontController
{

    public function show(Tag $tag, AccountManager $accountManager)
    {
        $content = $tag->content;

        $content->load('taggable');

        return $this->theme->render('tags.show', ['tag' => $tag]);
    }

}