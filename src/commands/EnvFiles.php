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


    protected $local_path   = '';


    protected $source_path  = '';


    protected function setPathsFromConfig(){

        $this->local_path   =  Config::get( 'env-manager.local_path' );
        $this->source_path  =  Config::get( 'env-manager.source_path' );
    }

} // -END trait EnvFiles {}