<?php
/**
 *
 */

namespace SouthernIns\EnvManager\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use SouthernIns\EnvManager\Shell\Diff;


/**
 * Class CheckCommand
 * @package SouthernIns\EnvManager\Commands
 */
class CheckCommand extends Command {

    /*
     * Trait with common properties
     */
    use EnvFiles;


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:check {file?}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check local Environment File(s) against source.';

    /**
     * command failure flag.
     * @var bool
     */
    protected $is_failed;
    

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

        $callback = [ $this, 'checkFile' ];
        $this->processFiles(  $callback, $files );

        if( $this->is_failed ){
            return 1;
        }

    } // END function handle()


    /**
     * Callback to use on each file being processed.
     *
     * @param $sourcePath
     * @param $localPath
     * @param $s3
     * @param $disk
     * @return int|void
     */
    public function checkFile( $sourcePath, $localPath, $s3, $disk ){

        if( !$disk->has( $localPath )){
            $this->error( "File: " . $localPath . " could not be found" );
            return;
        }

        if( !$s3->has( $sourcePath )){
            $this->error( "No Remote file matching " . $localPath . " exists for comparison." );
            return;
        }

        $source = $s3->get( $sourcePath );

        $sourceHash = sha1( $source ) ;

        $localHash = sha1( $disk->get( $localPath) );

        if( $sourceHash != $localHash ){
            $this->error( "There are ENV Differences that need to be addressed in: " . $localPath );

            $tmpfname = tempnam("/tmp", "FOO");

            $handle = fopen($tmpfname, "w");
            fwrite($handle, $source);
            fclose($handle);

            Diff::files( $localPath, $tmpfname );

            unlink($tmpfname);

            $this->is_failed = true;

        } else {
            $this->info( "No Changes In file: " . $localPath );
        }

    } //- END function checkFile()


} //- END class CheckCommand{}
