<?php

namespace Modules\Users\Auth\Throttler;

use Carbon\Carbon;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Http\Request;
use Modules\Users\Contracts\Throttler;
use Predis\Client;

/**
 * Class ThrottleManager
 * @package Modules\Users\Auth\Throttler
 */
class ThrottleManager implements Throttler
{
    const BASE_CACHE_KEY = 'users:auth:throttlers:';

    /**
     * @var Client
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
     * @param Client $redis
     * @param Repository $config
     * @param Queue $queue
     * @param Carbon $carbon
     * @param Request $request
     */
    public function __construct(Client $redis, Repository $config, Queue $queue, Carbon $carbon, Request $request)
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
     * @return bool|mixed
     */
    public function allows($email)
    {
        return $this->allowsEmail($email) && $this->allowsIp();
    }

    /**
     * @param $email
     * @return mixed|void
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

    /**
     * @param $ip
     * @param $email
     */
    public function cooldown($ip, $email)
    {
        $this->throttleIp(false, $ip);
        $this->throttleEmail(false, $email);
    }

    /**
     *
     */
    protected function allowsIp()
    {
        return $this->getIpCount() < $this->config->get('users.auth.max_login_attempts');
    }

    /**
     * @param $email
     * @return bool
     */
    protected function allowsEmail($email)
    {
        return $this->getEmailCount($email) < $this->config->get('users.auth.max_login_attempts');
    }

    /**
     * @param $field
     * @return string
     */
    protected function key($field)
    {
        return static::BASE_CACHE_KEY.$field;
    }

    /**
     *
     */
    protected function getIpCount()
    {
        $throttles = $this->redis->hget($this->key('ip'), $this->ip);

        return $throttles ?: 0;
    }

    /**
     * @param $email
     * @return int
     */
    protected function getEmailCount($email)
    {
        $throttles = $this->redis->hget($this->key('email'), $email);

        return $throttles ?: 0;
    }

    /**
     * @param $increment
     * @param null $ip
     * @return int
     */
    protected function throttleIp($increment, $ip = null)
    {
        if (empty($ip)) {
            $ip = $this->ip;
        }

        return $this->redis->hincrby($this->key('ip'), $ip, $increment ? 1 : -1);
    }

    /**
     * @param $increment
     * @param $email
     * @return int
     */
    protected function throttleEmail($increment, $email)
    {
        return $this->redis->hincrby($this->key('email'), $email, $increment ? 1 : -1);
    }
}
