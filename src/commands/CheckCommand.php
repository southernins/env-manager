<?php
/**
 *
 */

//namespace App\Console\Commands;
namespace SouthernIns\EnvManager\Commands;

//use Carbon\Carbon;
//use Illuminate\Support\Facades\App;
//use Illuminate\Support\Facades\Config;
//use Illuminate\Support\Facades\Cache;
//use Symfony\Component\Process\Process;
//use Symfony\Component\Process\Exception\ProcessFailedException;
//use SouthernIns\BuildTool\Shell\Composer;
//use SouthernIns\BuildTool\Shell\NPM;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;



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

        // Hoping with file* that even a single option passed in
        // comes as an array with one value for looping purposes
        $files = $this->argument( 'file' ) ?? $this->all;

        $callback = [ $this, 'checkFile' ];
        $this->processFiles(  $callback, $files );

    } // END function handle()


    public function checkFile( $sourcePath, $localPath, $s3 ){

        $this->info( $sourcePath );
        $this->info( $localPath );

        if( !$s3->has( $sourcePath )){
            $this->error( "File: " . $sourcePath . " could not be found" );
        }

        if( !Storage::has( $localPath )){
            $this->error( "File: " . $localPath . " could not be found" );
        }
//            $s3->put( $sourcePath, $fileContent);

    }


} //- END class CheckCommand{}
