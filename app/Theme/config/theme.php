<?php return [


    /**
     * Supported themes
     */
    'themes' => ['unify'],

    /**
     * Default theme to use.
     */
    'name' => 'unify',

    /**
     * Default theme email master template name to use
     *
     * '$theme::emails.layout.$name'
     *
     * This parameter represents the $name parameter in the above string
     */
    'email_template' => 'flat',

    /**
     * Location of the theme folders
     */
    'path' => base_path('themes'),

    /**
     * Location of the public files that will be published like assets etc.
     */
    'public_path' => 'themes',

];