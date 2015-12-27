<?php

namespace Modules\Contact;

/**
 * Class HasSocialLinks
 * @package Modules\Contact
 */
trait HasSocialLinks
{
    /**
     * @return mixed
     */
    public function socialLinks()
    {
        return $this->morphOne('Modules\Contact\SocialLinks', 'owner');
    }
}
