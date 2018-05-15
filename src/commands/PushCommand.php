<?php
/**
 *
 */

namespace SouthernIns\EnvManager\Commands;


use Illuminate\Support\Facades\Storage;


/*
 *
 */
class PushCommand extends Command {

    /*
     * Trait with common properties
     */
    use \EnvFiles;


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

        $this->setPathsFromConfig();

    } // -END __construct


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        // Hoping with file* that even a single option passed in
        // comes as an array with one value for looping purposes
        $files = $this->arguments( 'file' ) ?? $this->all;

        $s3 = Storage::disk( 's3' );

        // Loop to handle all/multiple files
        foreach( (array) $files as $file ){

            $sourcePath = $this->source_path . $file;
            $localPath = $this->local_path . $file;

//            $fileContent = $this->local_path . $file;

            $this-> info( "Source File : " . $sourcePath );
            $this-> info( "Local File : " . $localPath );

//            $s3->put( $sourcePath, $fileContent);
        }

    } // END function handle()


} //- END class PushCommand{}
