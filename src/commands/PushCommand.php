<?php
/**
 *
 */

namespace SouthernIns\EnvManager\Commands;

use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Command;


/*
 *
 */
class PushCommand extends Command {

    /*
     * Trait with common properties
     */
    use EnvFiles;


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:push {file?}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push Local Environment File(s) to source.';


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

        $callback = [ $this, 'pushFile' ];
        $this->processFiles(  $callback, $files );

    } // END function handle()

    public function pushFile( $sourcePath, $localPath, $s3, $disk ){

        // bounce with error when source( remote ) file does not exist )
        if( !$disk->has( $localPath )){
            $this->error( "File: " . $localPath . " could not be found" );
        }

        $this->line( "Committing: " . $localPath );
//            $s3->put( $sourcePath, $fileContent);

        if( $s3->has( $sourcePath )){

            // if a local file is found alert the user and get a confirmation before overwriting
            if( !$this->confirm( "This will overwrite your source file. Continue?" )){
                $this->error( "Moving On." );
                return;
            }
        }

        // Copy S3 file into Local file
        $s3->put( $sourcePath, $s3->get( $localPath ));

    } // -END pushFile


} //- END class PushCommand{}
