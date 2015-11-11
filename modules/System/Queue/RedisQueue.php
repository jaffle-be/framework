<?php namespace Modules\System\Queue;

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

    /**
     * Create a payload string from the given job and data.
     *
     * @param  string $job
     * @param  mixed  $data
     * @param  string $queue
     *
     * @return string
     */
    protected function createPayload($job, $data = '', $queue = null)
    {
        $payload = parent::createPayload($job, $data, $queue); // TODO: Change the autogenerated stub

        $payload = $this->setMeta($payload, 'EMAIL_FROM', env('EMAIL_FROM'));

        $payload = $this->setMeta($payload, 'EMAIL_FROM', env('EMAIL_FROM'));

        return $this->setMeta($payload, 'APP_URL', env('APP_URL'));
    }

    /**
     * Need to pop the redis job, so we can access our env variables
     *
     * Pop the next job off of the queue.
     *
     * @param  string  $queue
     * @return \Illuminate\Contracts\Queue\Job|null
     */
    public function pop($queue = null)
    {
        $original = $queue ?: $this->default;

        $queue = $this->getQueue($queue);

        if (! is_null($this->expire)) {
            $this->migrateAllExpiredJobs($queue);
        }

        $job = $this->getConnection()->lpop($queue);

        if (! is_null($job)) {
            $this->getConnection()->zadd($queue.':reserved', $this->getTime() + $this->expire, $job);

            return new RedisJob($this->container, $this, $job, $original);
        }
    }

}