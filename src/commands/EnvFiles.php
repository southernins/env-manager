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


} // -END trait EnvFiles {}