<?php namespace App\System\Queue;

class RedisQueue extends \Illuminate\Queue\RedisQueue
{

    /**
     * Get the queue or return the default.
     *
     * @param  string|null $queue
     *
     * @return string
     */
    protected function getQueue($queue)
    {
        return sprintf('queues:%s:%s',env('APP_NAME') , $queue ?: $this->default);
    }

}