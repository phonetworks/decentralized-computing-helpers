<?php

use Pho\DecentralizedComputing\Helpers;

class HelperTest extends \PHPUnit\Framework\TestCase 
{
    const KademliaIDSize = (160 / 4); // bit to bytes

    public function testIdGeneration()
    {
        $id = Helpers::generate_kademlia_id();
        $this->assertEquals(self::KademliaIDSize, strlen($id));
    }

    public function testHex2BinWithBigNum()
    {
        $big_num =  PHP_INT_MAX;
        $big_num_hex = base_convert($big_num, 10, 16);
        $big_num = (string) $big_num;
        $this->assertEquals(Helpers::dec_to_bin($big_num), Helpers::hex_to_bin($big_num_hex));
    }

    public function testHex2BinWithVeryBigNum()
    {
        $big_num =  bcmul(PHP_INT_MAX, 10); 
        $big_num_hex =   \BCMathExtended\BC::dechex($big_num);
        $this->assertEquals(Helpers::dec_to_bin($big_num), Helpers::hex_to_bin($big_num_hex));
    }

    public function testXorDistance()
    {
        $id1 =  Helpers::generate_kademlia_id();
        $id2 =  Helpers::generate_kademlia_id();
        $this->assertGreaterThan(0, Helpers::xor_distance($id1, $id2));
    }
} 