<?php

namespace Modules\Account\Jobs\Contact;

use App\Jobs\Job;
use Modules\Account\Account;
use Modules\Account\AccountContactInformation;

class NewInformation extends Job
{
    /**
     * @var Account
     */
    protected $account;

    /**
     * @var array
     */
    protected $input;

    public function __construct(Account $account, array $input)
    {
        $this->account = $account;
        $this->input = $input;
    }

    public function handle(AccountContactInformation $information)
    {
        $info = $information->newInstance($this->input);

        $info->account()->associate($this->account);

        return $info->save() ? $info : false;
    }
}
