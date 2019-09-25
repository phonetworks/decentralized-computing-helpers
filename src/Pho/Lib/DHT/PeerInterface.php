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

interface PeerInterface
{
    /**
     * ID of the Peer
     *
     * @return string
     */
    public function id(): string;

    /**
     * IP of the Peer
     *
     * @return string
     */
    public function ip(): string;

    /**
     * Port through the Peer serves the internet
     *
     * @return integer
     */
    public function port(): int;
}