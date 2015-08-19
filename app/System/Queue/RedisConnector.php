<?php namespace App\System\Queue;

class RedisConnector extends \Illuminate\Queue\Connectors\RedisConnector
{

    /**
     * Establish a queue connection.
     *
     * @param  array  $config
     * @return \Illuminate\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        //prefix our queue with our app name when we're running multiple sites on the same server.
        $config['queue'] = env('APP_NAME') . ':' . $config['queue'];

        return parent::connect($config);
    }

}