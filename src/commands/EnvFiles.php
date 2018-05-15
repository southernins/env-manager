<?php
/**
 *
 */

namespace SouthernIns\EnvManager\Commands;

use Illuminate\Support\Facades\Config;


/**
 * Trait EnvFiles
 */
trait EnvFiles {

    /**
     * List of all env files
     * @var array
     */
    protected $all = [
        '.env.local',
        '.env.production',
        '.env.staging'
    ];


    /*
     * local ENV path
     */
    protected $local_path   = '';


    /*
     * Source ENV path
     */
    protected $source_path  = '';


    /**
     * Function to get local and source path from configuration files
     */
    protected function setPathsFromConfig(){

        $this->local_path   =  Config::get( 'env-manager.local_path' );
        $this->source_path  =  Config::get( 'env-manager.source_path' );
    }

    protected function processFiles( $callback ){

        // Hoping with file* that even a single option passed in
        // comes as an array with one value for looping purposes
        $files = $this->argument( 'file' ) ?? $this->all;

        $s3 = Storage::disk( 's3' );

        // Loop to handle all/multiple files
        foreach( (array) $files as $file ){

            $sourcePath = $this->source_path . $file;
            $localPath = $this->local_path . $file;


//            $fileContent = $this->local_path . $file;

//            $callback( $stuff );
//            call_user_func( $callback );
            $param_arr = [
                'sourcePath'    => $sourcePath,
                'localPath'     => $localPath,
                's3'            => $s3
            ];

            call_user_func_array( $callback, $param_arr );

        }
    } // -END function processFiles()

} // -END trait EnvFiles {}