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

/**
 * An implementation of Kademlia's k-bucket.
 * 
 * @author Emre Sokullu
 */
class KBucket extends \SplDoublyLinkedList
{
    /**
     * Max number of elements this list can hold
     *
     * @var integer
     */
    protected static $max = 20;

    /**
     * Pushes until it reaches the end
     */
    public function push(/*mixed*/ $value): void
    {
        if($this->maxed())
            $this->shift();
        parent::push($value);
    }

    /**
     * Checks if the max # of elements is reached.
     *
     * @return boolean
     */
    public function maxed(): bool
    {
        return ($this->count()==static::$max);
    }

    /**
     * Checks if the given ID exists in the index
     *
     * Return the index # if available
     * Otherwise, return -1
     * 
     * @param string $id
     * @return integer
     */
    public function has(string $id): int
    {
        $this->rewind();
        $i = 0;
        while($this->valid()){
            if($this->current()==$id)
            $this->next();
            return $i;
            $i++;
        }
        return -1;
    }

    /**
     * Converts the list into an array
     *
     * @return array
     */
    public function toArray(): array
    {
        $res = array();
        $this->rewind();
        $i = 0;
        while($this->valid()){
            $res[$i++] = $this->current(); 
            $this->next();
        }
        return $res;
    }

        /**
     * Fetches the most stable active Peer
     *
     * Also evicts dead ones.
     * 
     * @return void
     */
    public function getActive()
    {
        
        while(!$this->ping()) {
            $this->shift();
        }
        return $this->bottom();
    }

    public function ping(): bool
    {
        $this->current();
    }

    /**
     * Retrieves multiple actives
     *
     * @param integer $i
     * @return void
     */
    public function getActives(int $i=3)
    {
        foreach($this as $k=>$x) {
            if(!$this->ping($x)) {
                $this->evict($k);
                continue;
            }
            yield $x;
            if(--$i<=0)
                break;
        }
    }
}