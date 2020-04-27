<?php
/**
 * Created by PhpStorm.
 * User: nakie
 * Date: 11/25/17
 * Time: 4:05 PM
 */

namespace SouthernIns\EnvManager\Shell;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


/**
 * Class Diff
 * @package SouthernIns\EnvManager\Shell
 */
class Diff {

    /**
     * Run diff cli tool given two file paths
     *
     * @param $pathOne
     * @param $pathTwo
     */
    static function files( $pathOne, $pathTwo ){

        $diff = new Process( 'diff ' . $pathOne . ' ' . $pathTwo );
        $diff->setTimeout(90);
        $diff->start();

        foreach ($diff as $type => $data) {

            if ($diff::OUT === $type) {
                echo "\n=>".$data;
            } else { // $process::OUT === $type
                echo "\n".$data;
            }
        }

    } //- END function files()

} //- END class Diff {}