<?php namespace App\Jobs;

abstract class Job {

    protected $alias;

    protected $email_from;

    protected $email_from_name;

    public function setup()
    {
        putenv('APP_ALIAS=' . $this->job->alias());
        putenv('EMAIL_FROM=' . $this->job->email_from());
        putenv('EMAIL_FROM_NAME=' . $this->job->email_from_name());
    }
}
