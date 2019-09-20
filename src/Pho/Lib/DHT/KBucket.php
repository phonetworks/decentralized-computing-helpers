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
}