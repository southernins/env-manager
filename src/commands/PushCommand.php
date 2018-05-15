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
    protected $signature = 'env:push {file*?}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push Local Environment File(s) to source.';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {

        parent::__construct();

        $this->setPathsFromConfig();

    } // -END __construct


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        $this->processFiles( $this->pushFile );

    } // END function handle()

    public function pushFile( $sourcePath, $localPath, $s3 ){

        $this->info( $sourcePath );
        $this->info( $localPath );


        if( !Storage::has( $localPath )){
            $this->error( "File: " . $localPath . " could not be found" );
        }

//            $s3->put( $sourcePath, $fileContent);

    } // -END pushFile


} //- END class PushCommand{}
