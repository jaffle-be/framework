<?php namespace Modules\Users\Auth\Throttler;

use Carbon\Carbon;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Contracts\Redis\Database;
use Illuminate\Http\Request;
use Modules\Users\Contracts\Throttler;

class ThrottleManager implements Throttler
{

    const BASE_CACHE_KEY = 'users:auth:throttlers:';

    /**
     * @var Database
     */
    protected $redis;

    /**
     * @var Repository
     */
    protected $config;

    /**
     * @var Queue
     */
    protected $queue;

    /**
     * @var Carbon
     */
    protected $carbon;

    /**
     * @var string
     */
    protected $ip;

    /**
     * @param Database   $redis
     * @param Repository $config
     * @param Queue      $queue
     * @param Carbon     $carbon
     * @param Request    $request
     */
    public function __construct(Database $redis, Repository $config, Queue $queue, Carbon $carbon, Request $request)
    {
        $this->redis = $redis;

        $this->config = $config;

        $this->queue = $queue;

        $this->carbon = $carbon;

        $this->ip = $request->getClientIp();
    }

    /**
     * Is the current user allowed to do another attempt.
     *
     * @param $email
     *
     * @return bool
     */
    public function allows($email)
    {
        return $this->allowsEmail($email) && $this->allowsIp();
    }

    /**
     * @param $email
     *
     * @return bool
     */
    public function throttle($email)
    {
        $this->throttleIp(true);
        $this->throttleEmail(true, $email);
        $this->startCooldown($email);
    }

    /**
     * @param $email
     */
    protected function startCooldown($email)
    {
        $seconds = $this->config->get('users.auth.throttling_interval');

        $delay = $this->carbon->now()->addSeconds($seconds);

        $this->queue->later($delay, new Cooldown($this->ip, $email));
    }

    public function cooldown($ip, $email)
    {
        $this->throttleIp(false, $ip);
        $this->throttleEmail(false, $email);
    }

    /**
     * @return bool
     */
    protected function allowsIp()
    {
        return $this->getIpCount() < $this->config->get('users.auth.max_login_attempts');
    }

    /**
     * @param $email
     *
     * @return bool
     */
    protected function allowsEmail($email)
    {
        return $this->getEmailCount($email) < $this->config->get('users.auth.max_login_attempts');
    }

    /**
     * @param string $field email or ip
     *
     * @return string
     */
    protected function key($field)
    {
        return static::BASE_CACHE_KEY . $field;
    }

    /**
     * @return int
     */
    protected function getIpCount()
    {
        $throttles = $this->redis->hget($this->key('ip'), $this->ip);

        return $throttles ?: 0;
    }

    /**
     * @param $email
     *
     * @return int
     */
    protected function getEmailCount($email)
    {
        $throttles = $this->redis->hget($this->key('email'), $email);

        return $throttles ?: 0;
    }

    /**
     * @param $increment
     *
     * @return mixed
     */
    protected function throttleIp($increment, $ip = null)
    {
        if(empty($ip))
        {
            $ip = $this->ip;
        }

        return $this->redis->hincrby($this->key('ip'), $ip, $increment ? 1 : -1);
    }

    /**
     * @param $increment
     * @param $email
     *
     * @return mixed
     */
    protected function throttleEmail($increment, $email)
    {
        return $this->redis->hincrby($this->key('email'), $email, $increment ? 1 : -1);
    }
}