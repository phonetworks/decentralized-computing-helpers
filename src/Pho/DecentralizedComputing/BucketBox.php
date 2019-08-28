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

class BucketBox
{

    protected $max_stores_per_bucket = 20;
    protected $buckets = array();

    public function __construct(string $id)
    {
        $this->buckets[0] = new Bucket;
        //$this->buckets[0]->add($id);
    }

    public function add(int $proximity, Entry $entry): void
    {
        if(!isset($this->buckets[$proximity])) {
            $this->buckets[$proximity] = new Bucket; 
            return;
        }
        $this->buckets[$proximity]->add($entry);
    }

    public function export(): array
    {
        return $this->buckets;
    }
}