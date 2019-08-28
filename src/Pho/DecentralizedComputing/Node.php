<?php

namespace Pho\DecentralizedComputing;

class Node
{

    protected $id;
    protected $buckets;
    protected $peers = [
        // root peers
    ];

    public function __construct()
    {
        $this->id = Helpers::generate_kademlia_id();
        $this->buckets = new BucketBox($this->id);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function addEntry(string $key, array $values): void
    {
        $entry = new Entry($key, $values);
        $proximity = Helpers::xor_distance($this->id, $entry->id());
        $this->buckets->add($proximity, $entry);
        $this->letPeersKnow($entry);
    }

    public function export(): array
    {
        return $this->buckets->export();
    }

}