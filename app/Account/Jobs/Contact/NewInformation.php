<?php namespace App\Account\Jobs\Contact;

use App\Account\Account;
use App\Account\AccountContactInformation;
use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class NewInformation extends Job implements SelfHandling
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