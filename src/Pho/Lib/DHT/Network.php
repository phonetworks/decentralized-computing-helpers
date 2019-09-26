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

/**
 * Network related static calls go here
 * 
 * @author Emre Sokullu <emre@phonetworks.org>
 */
class Network
{
    /**
     * Checks if the peer is still alive.
     *
     * @param PeerInterface $peer
     * @return boolean
     */
    public static function ping(PeerInterface $peer): bool
    {
        $uri = $peer->pingUrl(); 
        return self::pingUri($uri);
    }

    /**
     * Pings a URI
     *
     * @param string $uri
     * @return boolean
     */
    public static function pingUri(string $uri): bool
    {
        $res = json_decode(
                    @file_get_contents($uri),
                    true
        );
        return (isset($res["success"]) && $res["success"]);  
    }
}