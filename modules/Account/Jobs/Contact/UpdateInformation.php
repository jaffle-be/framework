<?php

namespace Modules\Account\Jobs\Contact;

use App\Jobs\Job;
use Modules\Account\AccountContactInformation;

class UpdateInformation extends Job
{

    /**
     * @var AccountContactInformation
     */
    protected $info;

    /**
     * @var array
     */
    protected $input;

    public function __construct(AccountContactInformation $info, array $input)
    {
        $this->info = $info;
        $this->input = $input;
    }

    public function handle()
    {
        $this->info->fill($this->input);

        return $this->info->save();
    }
}
