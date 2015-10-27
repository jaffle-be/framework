<?php namespace Modules\System\Seo;

interface SeoEntity
{

    public function getSeoTitle();

    public function getSeoDescription();

    public function getSeoImage();

    public function getSeoKeywords();

    public function getSeoUrl();

    public function getSeoTypeFacebook();

    public function getSeoTypeGoogle();

    public function getSeoTypeTwitter();

    public function getSeoAuthor();

}