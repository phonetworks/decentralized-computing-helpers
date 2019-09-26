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

use Pho\Lib\DHT\Mocks\ID;

class DummyPeer implements PeerInterface
{
    protected $id;
    protected $ip;
    protected $port;

    public function __construct(string $ip, int $port, string $id = "")
    {
        if(empty($id))
            $this->id = (string) (new ID);
        else
            $this->id = $id;
        $this->ip = $ip;
        $this->port = $port;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function ip(): string
    {
        return $this->ip;
    }

    public function port(): int
    {
        return $this->port;
    }

    public function pingUrl(): string
    {
        return $this->ip().":".$this->port()."/p2p/ping";
    }
}