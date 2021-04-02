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
    protected $localDir;


    /*
     * Remote ENV path
     */
    protected $remoteDir;

    /**
     * @var Storage file system object
     */
    protected $disk;

    /**
     * Function to get local and remote path from configuration files
     */
    protected function initConfig(){

        $this->localDir   = Config::get( 'env-manager.local_directory' );
        $this->remoteDir  = Config::get( 'env-manager.remote_directory' );
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
            'root' => $this->localDir,

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

            $remotePath = $this->remoteDir . '/' . $file;
            $localPath = $this->localDir . '/' . $file;

            $param_arr = [
                'remotePath'    => $remotePath,
                'localPath'     => $localPath,
                's3'            => $s3,
                'disk'          => $this->disk
            ];

            call_user_func_array( $callback, $param_arr );

        }

    } // -END function processFiles()

} // -END trait EnvFiles {}
