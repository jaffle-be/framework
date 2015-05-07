<?php

return [

    'auth' => [

        /**
         * If set to true, the user will not need to confirm his email.
         */
        'auto_confirmation' => false,

        //max attempts that can be made on a user account or from a specific ip within the throttling interval
        //this might be problematic for people using the same internet connection, therefor we set it at 10.
        'max_login_attempts' => 10,

        //the time it takes for a throttle to decrement in seconds
        'throttling_interval' => 10 * 60,
    ],

    /**
     * Disable certain listeners. Make sure to properly test things before actually running in production.
     */
    'listeners'        => [
        'App\Users\Auth\Events\UserRegistered' => [
            'App\Users\Auth\Subscribers\Email\UserRegistered@confirmation',
        ]
    ]

];