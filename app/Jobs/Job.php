<?php namespace App\Jobs;

use Modules\Account\AccountManager;

abstract class Job {

    protected $account;

    public function __construct()
    {
        $this->account = app(AccountManager::class)->account();
    }

    protected function baseData()
    {
        return [
            'account' => $this->account
        ];
    }

}
