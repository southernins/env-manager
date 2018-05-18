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


class Diff {

    static function files( $pathOne, $pathTwo ){

        $diff = new Process( 'diff ' . $pathOne , ' ' , $pathTwo );
        $diff->setTimeout(90);
        $diff->run();

        if( !$diff->isSuccessful() ){
            throw new ProcessFailedException( $diff );
        }

        // return Current Git Branch Name from command output
        return trim( $diff->getOutput() );
    }

} //- END class Diff {}