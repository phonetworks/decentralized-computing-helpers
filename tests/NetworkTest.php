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
use Pho\Lib\DHT\Mocks\Peer;

/**
 * Network Tests
 * 
 * @author Emre Sokullu <emre@phonetworks.org>
 */
class NetworkTest extends TestCase
{
    public function testPingUri()
    {
        $ping = Network::pingUri("https://google.com");
        $this->assertFalse($ping);
    }

    public function testPingPeerFalse()
    {
        $peer = new Peer("https://google.com", 443);
        $ping = Network::ping($peer);
        $this->assertFalse($ping);
    }

    public function testPingPeerTrue()
    {
        //eval(\Psy\sh());
    }
}