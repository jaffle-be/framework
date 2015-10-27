<?php

return [

    /*
     * if you have any model that implements addressOwner, you should add it to this list.
     * the key represents the key from the frontend widget.
     * the value is the class it should use to resolve the owner.
     */
    'address_owners' => [
        'account' => 'Modules\Account\AccountContactInformation',
        'user'    => 'Modules\Users\User'
    ],

    'social_links_owners' => [
        'account' => 'Modules\Account\Account',
        'user'    => 'Modules\Users\User'
    ]

];