<?php declare(strict_types = 1);

/*
 * This file is part of the Pho package.
 *
 * (c) Emre Sokullu <emre@phonetworks.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pho\DHT;

class RouteTree
{
    const FILL = "x";

    protected $id;
    protected $debug = false;
    protected $kbucket_size = 20;
    protected $bit_length = 128;
    protected $key_length = 0;
    protected $tree = [];

    public function __construct(string $id, int $kbucket_size, int $bit_length, bool $debug = false)
    {
        $this->id = $id;
        $this->kbucket_size = $kbucket_size;
        $this->bit_length = $bit_length;
        $this->debug = $debug;
        //$this->tree[0] = new KBucket($this->kbucket_size, $this->bit_length, $this->debug);
    }

    public function push(/*mixed*/ $entity)
    {
        $key = Utils::xor_bucket($entity->id(), $this->id);
        $this->initialize_leaf($key);
        $this->tree[$key]->push($entity);
    }
    
    public function toArray(): array
    {
        $res = [];
        foreach($this->tree as $i=>$kbucket) {
            $res[$i] = $kbucket->toArray();
        }
        return $res;
    }

    public function initialize_leaf(string $key): void
    {
        if(!$this->has($key))
            $this->tree[$key] = new KBucket($this->kbucket_size, $this->bit_length, $this->debug);
    }

    public function kbucket( $key): KBucket
    {
        return $this->tree[$key];
    }

    public function has($key): bool
    {
        return isset($this->tree[$key]);
    }

    public function dump(): array
    {
        return $this->tree;
    }

    public function keyLength(): int
    {
        return $this->key_length;
    }

    /**
     * Dumps the internal state. 
     *
     * For debugging purposes
     *
     * @return void
     */
    public function probe(): void
    {
        var_dump($this->tree);
    }


}