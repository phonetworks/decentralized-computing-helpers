<?php

/*
 * This file is part of the Pho package.
 *
 * (c) Emre Sokullu <emre@phonetworks.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pho\DecentralizedComputing;

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

const HEXADECIMALS = "0123456789ABCDEF";
const DECIMALS = "0123456789";

/**
 * Computes XOR distance between two numbers.
 * @link https://stackoverflow.com/questions/27081124/binary-separation-distance-java
 * 
 * @param int $num1
 * @param int $num2 
 * 
 * @return int The distance
 */
public static function xor_distance(int $num1, int $num2): int
{
 $count = 0;
 $xor = $num1 xor $num2;
 while($xor!=0) {
	$count++;
	$xor &= ($xor-1);
 }
 return $count;
}

/**
 * Computes XOR distance between two strings.
 * @see xor_distance
 * 
 * @param string $string1
 * @param string $string2 
 * 
 * @return int The distance
 */
public static function string_xor_distance(string $string1, string $string2): int
{
	$num1 = convert_base_for_bignum(sha1($string1), self::HEXADECIMALS, self::DECIMALS);
	$num2 = convert_base_for_bignum(sha1($string2), self::HEXADECIMALS, self::DECIMALS);
	return self::xor_distance($num1, $num2);
}



/**
 * Like PHP's native base_convert function
 * but works for bignumbers.
 * 
 * @link https://gist.github.com/macik/4758146
 * 
 * @param string $numberInput
 * @param string $fromBaseInput
 * @param string $toBaseInput
 * 
 * @return string
 */
public static function convert_base_for_bignum(string $numberInput, string $fromBaseInput, string $toBaseInput): string
 {
     if ($fromBaseInput==$toBaseInput) 
        return $numberInput;

     $fromBase = str_split($fromBaseInput,1);
     $toBase = str_split($toBaseInput,1);
     $number = str_split($numberInput,1);
     $fromLen=strlen($fromBaseInput);
     $toLen=strlen($toBaseInput);
     $numberLen=strlen($numberInput);
     $retval='';

     if ($toBaseInput == '0123456789')
     {
         $retval=0;
         for ($i = 1;$i <= $numberLen; $i++)
             $retval = bcadd($retval, bcmul(array_search($number[$i-1], $fromBase),bcpow($fromLen,$numberLen-$i)));
         return $retval;
     }
     
     if ($fromBaseInput != '0123456789')
         $base10=convBase($numberInput, $fromBaseInput, '0123456789');
     else
         $base10 = $numberInput;
     if ($base10<strlen($toBaseInput))
         return $toBase[$base10];
     while($base10 != '0')
     {
         $retval = $toBase[bcmod($base10,$toLen)].$retval;
         $base10 = bcdiv($base10,$toLen,0);
     }
     return $retval;
 }


}
