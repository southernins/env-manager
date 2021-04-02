<?php

return [
    /*
     |--------------------------------------------------------------------------
     |  Env Manager Configuration File
     |--------------------------------------------------------------------------
     |
     |
     */

    /*
     * Location of ENV source files
     */
    'remote_directory' => env( 'SOURCE_ENV_PATH', 'env_files' ),

    /*
     * Local storage path for env files ( default project root/base )
     */
    'local_directory'  => env( 'LOCAL_ENV_PATH', '.' ),

    /*
     * List of files to process when no single file is specified.
     */
    'all_files' => [
        '.env.production',
        '.env.staging'
    ]

];
