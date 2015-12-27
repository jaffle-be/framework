<?php

namespace Modules\Marketing\Newsletter;

/**
 * Class CampaignConfig
 * @package Modules\Marketing\Newsletter
 */
class CampaignConfig
{
    /**
     * @return string
     */
    public function fromEmail()
    {
        return 'thomas.warlop@gmail.com';
    }

    /**
     * @return string
     */
    public function fromName()
    {
        return 'thomas';
    }

    /**
     * @return string
     */
    public function toName()
    {
        return '*FNAME*';
    }
}
