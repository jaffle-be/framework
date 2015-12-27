<?php

namespace Modules\System\Http;

use Modules\Blog\Http\BlogFrontControlling;
use Modules\Blog\PostTranslation;
use Modules\Pages\Http\PagesFrontControlling;
use Modules\Pages\PageTranslation;
use Modules\System\Uri\Uri;

class UriController extends FrontController
{

    use BlogFrontControlling, PagesFrontControlling;

    public function handle(Uri $uri, Uri $suburi = null, Uri $subesturi = null)
    {
        //use the last argument that is set to display
        $display = $this->resourceToDisplay($uri, $suburi, $subesturi);

        $owner = $display->owner;

        if ($owner instanceof PostTranslation) {
            $repo = app('Modules\Blog\PostRepositoryInterface');

            return $this->renderPostDetail($owner, $repo);
        } elseif ($owner instanceof PageTranslation) {
            $repo = app('Modules\Pages\PageRepositoryInterface');

            return $this->renderPageDetail($owner, $repo);
        }

        abort(404);
    }

    /**
     * @return Uri
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
