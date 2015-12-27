<?php

namespace Modules\Account\Jobs\Contact;

use App\Jobs\Job;
use Modules\Account\AccountContactInformation;

/**
 * Class UpdateInformation
 * @package Modules\Account\Jobs\Contact
 */
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

    /**
     * @param AccountContactInformation $info
     * @param array $input
     */
    public function __construct(AccountContactInformation $info, array $input)
    {
        $this->info = $info;
        $this->input = $input;
    }

    /**
     * @return bool
     */
    public function handle()
    {
        $this->info->fill($this->input);

        return $this->info->save();
    }
}
