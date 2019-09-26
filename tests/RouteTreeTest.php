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

use Pho\Lib\DHT\Network;
use Pho\Lib\DHT\Utils;
use Pho\Lib\DHT\Mocks\ID;

/**
 * Route Tree
 * 
 * @author Emre Sokullu <emre@phonetworks.org>
 */
class RouteTreeTest extends TestCase
{
    public function testBuild()
    {
        $seeds = [];
        $network_ip = $this->faker->ipv4;
        $network_port = rand(80, 9000);
        $network_peer = new DummyPeer($network_ip, $network_port);
        $this->network_id = $network_peer->id();
        $this->network = new Router($network_peer, $seeds, ["debug"=>true]);
        $this->network->bootstrap();
        $this->assertCount(1, $this->network->tree()[0]);
        $this->assertTrue(true);
        return $this->network;
    }

    /**
     * @depends testBuild
     *
     * @return void
     */
    public function testAddPeer($network)
    {
        $seeds = [];
        $peer_ip = $this->faker->ipv4;
        $peer_port = rand(80, 9000);
        $peer = new DummyPeer($peer_ip, $peer_port);
        $this->peer_id = $peer->id();
        $network->touch($peer);
        $this->assertCount(2, $network->tree());
    }

    /**
     * There are so many peers
     * not all of them will fill in the buckets,
     *
     * @return void
     */
    public function testSoManyToAPointWhereKBucketsWillFillToTheEnd()
    {
        //$this->markTestSkipped();
        $seeds = [];
        $res = $this->_testX(1000, [], false);
        $all_peers = $res[2];
        $all_in_buckets = $this::array_flatten($res[3]);
        $this->assertLessThan(count($all_peers), count($all_in_buckets));
    }

    public function testFindPeer()
    {
        $res = $this->_testX(100, [], false, 1000 /* large bucket */);
        $ip = $this->faker->ipv4;
        $port = rand(8000, 9000);
        $peer = new DummyPeer($ip, $port);
        $this->network->touch($peer);
        $distance = Utils::xor_bucket($this->network->id(), $peer->id());
        $this->assertSame($this->network->findPeers($peer->id()), $peer);
    }
}