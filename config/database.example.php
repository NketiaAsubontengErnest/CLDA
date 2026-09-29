<?php
/**
 * Database settings for each environment.
 * The app picks one automatically from the address it is opened on:
 *   - localhost / 127.0.0.1 / command line  -> 'local'
 *   - anything else (your live domain)      -> 'production'
 * So the same files work offline and online with no editing after upload.
 *
 * Production values are the cPanel database details.
 */
return [
    'local' => [
        'host'     => 'localhost',
        'name'     => 'clda_db',
        'user'     => 'root',
        'password' => '',
    ],
    'production' => [
        'host'     => 'localhost',
        'name'     => 'CPANEL_DB_NAME',
        'user'     => 'CPANEL_DB_USER',
        'password' => 'CPANEL_DB_PASSWORD',
    ],
];
