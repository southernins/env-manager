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



class PullCommand extends Command {

    /*
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

        $callback = [ $this, 'pullFile' ];
        $this->processFiles(  $callback );

    } // END function handle()

    public function pullFile( $sourcePath, $localPath, $s3 ){

        $this->info($sourcePath);
        $this->info($localPath);

        if( !$s3::has( $localPath )){
            $this->error( "File: " . $sourcePath . " could not be found" );
        }

//            $s3->put( $sourcePath, $fileContent);

    }



} //- END class PullCommand{}
