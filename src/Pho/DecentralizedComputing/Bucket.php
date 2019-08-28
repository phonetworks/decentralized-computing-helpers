<?php declare(strict_types = 1);

/*
 * This file is part of the Pho package.
 *
 * (c) Emre Sokullu <emre@phonetworks.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pho\DecentralizedComputing;

class Bucket
{

    protected $max_stores_per_bucket = 20;

    protected $store = [];

    public function probe(): void
    {
        var_dump($this->store);
    }

    public function add(Entry $entry)
    {
        $id = $entry->id();
        if(count($this->store)<$this->max_stores_per_bucket) {
            $this->store[$id] = $entry;
            return;
        }
    }

    public function export(): array
    {
        return $this->store;
    }

    public function __toString(): string
    {
        return print_r($this->store, true);
    }

}