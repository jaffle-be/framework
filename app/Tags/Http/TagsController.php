<?php namespace App\Tags\Http;

use App;
use App\Account\AccountManager;
use App\System\Http\Controller;
use App\Tags\Tag;

class TagsController extends Controller
{

    public function index()
    {
        return 'show all tags here';
    }

    public function show(Tag $tag, AccountManager $accountManager)
    {
        $content = $tag->content;

        $content->load('taggable');

        return $this->theme->render('tags.show', ['tag' => $tag]);
    }

}