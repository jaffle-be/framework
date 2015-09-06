<?php namespace App\System\Queue;

use Illuminate\Support\Arr;

class RedisJob extends \Illuminate\Queue\Jobs\RedisJob
{

    public function email_from()
    {
        return Arr::get(json_decode($this->job, true), 'EMAIL_FROM');
    }

    public function email_from_name()
    {
        return Arr::get(json_decode($this->job, true), 'EMAIL_FROM_NAME');
    }

    public function app_url()
    {
        app('log')->notice(Arr::get(json_decode($this->job, true), 'APP_URL'));

        return Arr::get(json_decode($this->job, true), 'APP_URL');
    }

}