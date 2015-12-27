<?php

namespace Modules\Marketing\Jobs\Newsletter;

use App\Jobs\Job;
use Modules\Marketing\Newsletter\Campaign;

/**
 * Class UpdateCampaign
 * @package Modules\Marketing\Jobs\Newsletter
 */
class UpdateCampaign extends Job
{
    /**
     * @var Campaign
     */
    protected $newsletter;

    /**
     * @var array
     */
    protected $input;

    /**
     * @param Campaign $newsletter
     * @param array $input
     */
    public function __construct(Campaign $newsletter, array $input)
    {
        $this->newsletter = $newsletter;
        $this->input = $input;
    }

    /**
     * @return bool
     */
    public function handle()
    {
        $this->newsletter->fill($this->input);

        return $this->newsletter->save();
    }
}
