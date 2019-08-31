<?php declare(strict_types = 1);

/*
 * This file is part of the Pho package.
 *
 * (c) Emre Sokullu <emre@phonetworks.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pho\Lib\DHT;

use BCMathExtended\BC as BCe;

/**
 * This class contains helper methods for decentralized
 * computing in PHP.
 * 
 * All methods in this class are static.
 * 
 * @author Emre Sokullu <emre@phonetworks.orgg>
 */
class Utils
{
    /**
     * Computes XOR distance between two numbers.
     * 
     * Parameters in string format to deal with bignums
     *
     * @link https://stackoverflow.com/questions/27081124/binary-separation-distance-java
     * 
     * @param string $num1 in hexadecimal format
     * @param string $num2 in hexadecimal format
     * 
     * @return int The distance in decimal format
     */
    public static function xor_distance(string $num1, string $num2): int
    {
        $count = 0;
        $num1 = BCe::hexdec($num1);
        $num2 = BCe::hexdec($num2);
        $xor = BCe::bitXor((string) $num1, (string) $num2);
        $xor_bin = self::dec_to_bin($xor);
        return substr_count($xor_bin, "1");
        /*
        while($xor!=0) {
            $count++;
            $xor &= ($xor-1);
        }
        return $count;
        */
    }


    public static function hex_to_bin(string $hex, int $padding = -1): string
    {
        
        return self::dec_to_bin(
            BCe::hexdec($hex),
            $padding
        );
    }

    // https://stackoverflow.com/a/25017999
    public static function dec_to_bin(/*mixed*/ $decimal_i, int $padding = -1): string
    {
        \bcscale(0);
        $binary_i = '';
        do
        {
            $binary_i = \bcmod($decimal_i,'2') . $binary_i;
            $decimal_i = \bcdiv($decimal_i,'2');
        } while (\bccomp($decimal_i,'0'));

        if($padding!=-1) {
            $binary_i = \str_pad($binary_i, $padding, "0", STR_PAD_LEFT);
        }

        return $binary_i;
    }


}
