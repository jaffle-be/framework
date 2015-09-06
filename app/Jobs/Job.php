<?php namespace App\Jobs;

use Illuminate\Contracts\Config\Repository;

abstract class Job {

    protected $email_from;

    protected $email_from_name;

    public function setup()
    {
        /** @var Repository $config */
        $config = app('config');

        $config->set([
            'mail.from' => ['address' => $this->job->email_from(), 'name' => $this->job->email_from_name()]
        ]);

        $config->set('app.url', $this->job->app_url());

        app('url')->forceRootUrl($config->get('app.url'));
    }
}
