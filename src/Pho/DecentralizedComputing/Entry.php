<?php

namespace Pho\DecentralizedComputing;

class Entry
{
    protected $id;
    protected $key;
    protected $values;

    public function __construct(string $key, array $values)
    {
        $this->id = Helpers::generate_kademlia_id();
        $this->key = $key;
        $this->values = $values;
    }

    public function id(): string
    {
        return $this->id;
    }
    
}