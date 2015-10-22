<?php namespace App\System\Http;

use App\Blog\Http\BlogFrontControlling;
use App\Blog\PostTranslation;
use App\Pages\Http\PagesFrontControlling;
use App\Pages\PageTranslation;
use App\System\Uri\Uri;

class UriController extends FrontController
{
    use BlogFrontControlling, PagesFrontControlling;

    public function handle(Uri $uri, Uri $suburi = null, Uri $subesturi = null)
    {
        //use the last argument that is set to display
        $display = $this->resourceToDisplay($uri, $suburi, $subesturi);

        $owner = $display->owner;

        if($owner instanceof PostTranslation)
        {
            $repo = app('App\Blog\PostRepositoryInterface');

            return $this->renderPostDetail($owner, $repo);
        }
        else if($owner instanceof PageTranslation)
        {
            $repo = app('App\Pages\PageRepositoryInterface');

            return $this->renderPageDetail($owner, $repo);
        }

        abort(404);
    }

    /**
     * @param Uri $uri
     * @param Uri $suburi
     * @param Uri $subesturi
     */
    protected function resourceToDisplay(Uri $uri, Uri $suburi = null, Uri $subesturi = null)
    {
        $display = $subesturi;

        if (!$display) {
            $display = $suburi;
        }

        if (!$display) {
            $display = $uri;
        }

        return $display;
    }

}