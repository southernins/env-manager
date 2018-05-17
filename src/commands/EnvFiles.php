<?php
/**
 *
 */

namespace SouthernIns\EnvManager\Commands;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;


/**
 * Trait EnvFiles
 */
trait EnvFiles {

    /**
     * List of all env files
     * @var array
     */
    protected $all = [];


    /*
     * local ENV path
     */
    protected $local_path;


    /*
     * Source ENV path
     */
    protected $source_path;

    /**
     * @var Storage file system object
     */
    protected $disk;

    /**
     * Function to get local and source path from configuration files
     */
    protected function initConfig(){

        $this->local_path   = Config::get( 'env-manager.local_path' );
        $this->source_path  = Config::get( 'env-manager.source_path' );
        $this->all          = Config::get( 'env-manager.all_files' );

        $this->createDisk();
    }

    /**
     * Create Storage Disk for App Root.
     *
     */
    protected function createDisk(){

        /**
         * * Adding the config temporarly so we dont have a root folder disk
         * laying around all the time.
         */
        $config = [

            'driver' => 'local',
            'root' => $this->local_path,

        ];

        Config::set( 'filesystems.disks.env-manager', $config);

        $this->disk = Storage::disk( 'env-manager' );

    } //- END function createDisk()


    /**
     * @param $callback
     * @param $files
     */
    protected function processFiles( $callback, $files ){

        $s3 = Storage::disk( 's3' );

        if( empty( $files ) ){
            $this->error( "No files to process. Please check your configuration or use the -file argument ");
        }

        // Loop to handle all/multiple files
        foreach( (array) $files as $file ){

            $sourcePath = $this->source_path . '/' . $file;
            $localPath = $this->local_path . '/' . $file;

            $param_arr = [
                'sourcePath'    => $sourcePath,
                'localPath'     => $localPath,
                's3'            => $s3,
                'disk'          => $this->disk
            ];

            call_user_func_array( $callback, $param_arr );

        }

    } // -END function processFiles()

} // -END trait EnvFiles {}