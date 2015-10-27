<?php namespace Modules\Tags\Http;

use App;
use Modules\Account\AccountManager;
use Modules\System\Http\FrontController;
use Modules\Tags\Tag;

class TagsController extends FrontController
{

    public function show(Tag $tag, AccountManager $accountManager)
    {
        $content = $tag->content;

        $content->load('taggable');

        return $this->theme->render('tags.show', ['tag' => $tag]);
    }

}