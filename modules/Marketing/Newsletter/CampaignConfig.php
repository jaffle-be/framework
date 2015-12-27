<?php

namespace Modules\Marketing\Newsletter;

class CampaignConfig
{
    public function fromEmail()
    {
        return 'thomas.warlop@gmail.com';
    }

    public function fromName()
    {
        return 'thomas';
    }

    public function toName()
    {
        return '*FNAME*';
    }
}
