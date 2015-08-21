<?php namespace App\Contact;

trait HasSocialLinks
{
    public function socialLinks()
    {
        return $this->morphOne('App\Contact\SocialLinks', 'owner');
    }

}