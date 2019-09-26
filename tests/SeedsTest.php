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
class SeedsTest extends TestCase
{
    public function testCount()
    {
        $seeds = Constants::seeds();
        $this->assertCount(2, $seeds);
    }

    public function testInterface()
    {
        $seeds = Constants::seeds();
        $this->assertInstanceOf(PeerInterface::class, $seeds[0]);
    }
}