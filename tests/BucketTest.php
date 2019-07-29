<?php

use Pho\DecentralizedComputing\Helpers;
use Pho\DecentralizedComputing\Bucket;

class BucketTest extends \PHPUnit\Framework\TestCase 
{
    protected $max_stores_per_bucket = 20;

    protected function _testXIds(int $limit, bool $inspect = false)
    {
        $ids = array();
        //$binaries = array();
        $bucket = new Bucket;
        for($i=0;$i<$limit;$i++) {
            $ids[$i] = Helpers::generate_kademlia_id();
            //$binaries[$i] = Helpers::hex_to_bin($ids[$i], Helpers::KademliaIdBinaryLength);
            $bucket->add($ids[$i], [rand()]);
        }
        $store = $bucket->export();
        if($inspect)
            eval(\Psy\sh());
        $this->assertGreaterThanOrEqual(ceil($limit/$this->max_stores_per_bucket), count($store));
        $totalItems = array_sum(array_map("count", $store));
        $this->assertEquals($limit, $totalItems);
    }   

    public function test100Ids()
    {
        $this->_testXIds(100);
    }

    public function test500Ids()
    {
        $this->_testXIds(500);
    }

    public function test1000Ids()
    {
        $this->_testXIds(1000);
    }

    public function test2000Ids()
    {
        $this->_testXIds(2000);
    }

    public function test5000Ids()
    {
        $this->_testXIds(5000);
    }

    public function test10000Ids()
    {
        $this->_testXIds(10000, true);
    }
}