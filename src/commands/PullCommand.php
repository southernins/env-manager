<?php
/**
 *
 */

namespace SouthernIns\EnvManager\Commands;

use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Command;


/**
 * Class PullCommand
 * @package SouthernIns\EnvManager\Commands
 */
class PullCommand extends Command {

    /**
     * Trait with common properties
     */
    use EnvFiles;


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:pull {file?}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull Environment File(s) from source.';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        $this->initConfig();

        // Hoping with file* that even a single option passed in
        // comes as an array with one value for looping purposes
        $files = $this->argument( 'file' ) ?? $this->all;

        $callback = [ $this, 'pullFile' ];
        $this->processFiles(  $callback, $files );

    } // END function handle()

    /**
     * Callback function to proccess each file for this command
     * @param $sourcePath
     * @param $localPath
     * @param $s3
     */
    public function pullFile( $sourcePath, $localPath, $s3, $disk ){

        // bounce with error when source( remote ) file does not exist )
        if( !$s3->has( $sourcePath )){
            $this->error( "File: " . $sourcePath . " could not be found" );
            return;
        }

        $this->line( "Updating: " . $localPath );

        if( $disk->has( $localPath )){

            // if a local file is found alert the user and get a confrimation before overriting
            if( !$this->confirm( "This will overwrite your local file. Continue?" )){
                $this->error( "Moving On." );
                return;
            }
        }

        // Copy S3 file into Local file
        $disk->put( $localPath, $s3->get( $sourcePath ));


    } // -END function pullFile()


} //- END class PullCommand{}
