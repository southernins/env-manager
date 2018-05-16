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
    'source_path' => env( 'SOURCE_ENV_PATH', 'env_files' ),

    /*
     * Local storage path for env files ( default app root )
     */
    'local_path'  => env( 'LOCAL_ENV_PATH', base_path( )),


];