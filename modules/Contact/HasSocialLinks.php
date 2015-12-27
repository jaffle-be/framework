<?php

namespace Modules\Contact;

trait HasSocialLinks
{
    public function socialLinks()
    {
        return $this->morphOne('Modules\Contact\SocialLinks', 'owner');
    }
}
