<?php namespace App\System\Queue;

use Illuminate\Support\Arr;

class RedisJob extends \Illuminate\Queue\Jobs\RedisJob
{

    /**
     * Get the number of times the job has been attempted.
     *
     * @return int
     */
    public function alias()
    {
        return Arr::get(json_decode($this->job, true), 'ALIAS');
    }

    public function email_from()
    {
        return Arr::get(json_decode($this->job, true), 'EMAIL_FROM');
    }

    public function email_from_name()
    {
        return Arr::get(json_decode($this->job, true), 'EMAIL_FROM_NAME');
    }

}