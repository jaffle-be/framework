<?php namespace Modules\Marketing\Jobs\Newsletter;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Modules\Marketing\Newsletter\Campaign;

class UpdateCampaign extends Job implements SelfHandling
{

    /**
     * @var Campaign
     */
    protected $newsletter;

    /**
     * @var array
     */
    protected $input;

    public function __construct(Campaign $newsletter, array $input)
    {
        $this->newsletter = $newsletter;
        $this->input = $input;
    }

    public function handle()
    {
        $this->newsletter->fill($this->input);

        return $this->newsletter->save();
    }

}