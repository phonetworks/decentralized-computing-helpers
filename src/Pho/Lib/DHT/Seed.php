<?php

namespace Pho\Lib\DHT;

/**
 * Seed
 * 
 * @author Emre Sokullu <emre@phonetworks.org>
 */
class Seed extends DummyPeer implements PeerInterface
{
    public function __construct(string $url, string $id)
    {
        $this->id = $id;
        $this->ip = $url;
        $this->port = 443;
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
        return $this->ip()."/p2p/ping?public_id=".$this->id();
    }
}