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
     * @return string The distance in decimal format
     */
    public static function xor_distance(string $num1, string $num2): string
    {
        $count = 0;
        $num1 = BCe::hexdec(static::cleanupId((string) $num1));
        $num2 = BCe::hexdec(static::cleanupId((string) $num2));
        $xor = BCe::bitXor($num1, $num2);
        return $xor;
    }

    public static function xor_bucket(string $num1, string $num2): string
    {
        $distance = static::xor_distance($num1, $num2);
        return BCe::div(BCe::log($distance), BCe::log("2"));
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

    /**
     * Finds the longest common prefix in given sets of strings
     * 
     * Useful in seeking the common prefix of binaries in a Kademlia
     * tree. 
     * 
     * Good for debugging but not recommended for production as it would 
     * be slow.
     *
     * @param array $arr A set of string objects.
     * 
     * @return string The common prefix
     */
    public static function longest_common_prefix(array $arr): string 
    {
        $common_str= $arr[0];
        foreach ($arr as $key=>$value)
        {
            $arr[$key] = \str_split($value);
        }
        $length = \count($arr);
        $temp = $arr[0];
        $len = \count($temp);
        for ($i=0;$i<$len;$i++)
        {
            for ($n=1; $n<$length; $n++)
            {
                if($temp[$i]!=$arr[$n][$i])
                {
                    if($i == 0)
                    {
                        return "";
                    }
                    return \substr($common_str,0,$i);
                }
            }
            if ($i==$len-1)
            {
                return $common_str;
            }
        }
    }

    /**
     * Clean up ID
     * 
     * So that the XOR computations can be made
     * strtolower and remove dashes.
     *
     * @param string $id
     * @return string
     */
    public static function cleanupId(string $id): string
    {
        return \str_replace("-", "", \strtolower($id));
    }

    /**
     * Returns true if both IDs are the same
     *
     * @param string $id1
     * @param string $id2
     * @return boolean
     */
    public static function checkForEqualIds(string $id1, string $id2): bool
    {
        return (static::cleanupId($id1) == static::cleanupId($id2));
    }

}
