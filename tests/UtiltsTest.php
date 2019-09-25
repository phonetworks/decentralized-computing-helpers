<?php

/*
 * This file is part of the Pho package.
 *
 * (c) Emre Sokullu <emre@phonetworks.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pho\Lib\DHT;

use Pho\Lib\DHT\Mocks\ID;

class HelperTest extends \PHPUnit\Framework\TestCase 
{

    public function testHex2BinWithBigNum()
    {
        $big_num =  PHP_INT_MAX;
        $big_num_hex = base_convert($big_num, 10, 16);
        $big_num = (string) $big_num;
        $this->assertEquals(Utils::dec_to_bin($big_num), Utils::hex_to_bin($big_num_hex));
    }
    public function testHex2BinWithVeryBigNum()
    {
        $big_num =  bcmul(PHP_INT_MAX, 10); 
        $big_num_hex =   \BCMathExtended\BC::dechex($big_num);
        $this->assertEquals(Utils::dec_to_bin($big_num), Utils::hex_to_bin($big_num_hex));
    }
    public function testXorDistance()
    {
        $id1 =  ID::generate();
        $id2 =  ID::generate();
        $this->assertGreaterThan(0, Utils::xor_bucket($id1, $id2));
    }
} 