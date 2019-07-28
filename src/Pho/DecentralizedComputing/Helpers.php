<?php declare(strict_types = 1);

/*
 * This file is part of the Pho package.
 *
 * (c) Emre Sokullu <emre@phonetworks.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pho\DecentralizedComputing;

use BCMathExtended\BC;

/**
 * This class contains helper methods for decentralized
 * computing in PHP.
 * 
 * All methods in this class are static.
 * 
 * @author Emre Sokullu <emre@phonetworks.orgg>
 */
class Helpers
{

    /**
     * Generates a cryptographically secure random Id
     * 
     * Completely random
     * better for security
     * To use as key and node ID
     * 160 bits, e.g. 20 bytes
     *
     * @return string
     */
    public static function generate_kademlia_id(): string
    {
        return  \bin2hex(\random_bytes(20));
    }

    /**
     * Computes XOR distance between two numbers.
     * 
     * Parameters in string format to deal with bignums
     *
     * @link https://stackoverflow.com/questions/27081124/binary-separation-distance-java
     * 
     * @param string $num1 in decimal format
     * @param string $num2 in decimal format
     * 
     * @return int The distance in decimal format
     */
    public static function xor_distance(string $num1, string $num2): int
    {
        $count = 0;
        $xor = BC::bitXor($num1, $num2);
        while($xor!=0) {
            $count++;
            $xor = BC::bitXor($xor, bcsub($xor, 1));  //$xor &= ($xor-1);
        }
        return $count;
    }


    public static function hex_to_bin(string $hex): string
    {
        // https://stackoverflow.com/a/25017999
        $dec2bin = function ($decimal_i)
        {
            \bcscale(0);
            $binary_i = '';
            do
            {
            $binary_i = \bcmod($decimal_i,'2') . $binary_i;
            $decimal_i = \bcdiv($decimal_i,'2');
            } while (\bccomp($decimal_i,'0'));

            return($binary_i);
        };
        return $dec2bin(
            BC::hexdec($hex)
        );
    }


}
