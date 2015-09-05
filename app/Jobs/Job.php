<?php namespace App\Jobs;

use Illuminate\Contracts\Config\Repository;

abstract class Job {

    protected $email_from;

    protected $email_from_name;

    public function setupEmailConfig()
    {
        /** @var Repository $config */
        $config = app('config');

        $config->set([
            'mail.from' => ['address' => $this->job->email_from(), 'name' => $this->job->email_from_name()]
        ]);
    }
}
