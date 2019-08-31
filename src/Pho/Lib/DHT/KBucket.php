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
 * An implementation of Kademlia's k-bucket. This implementation aligns to the requirements given in the original Kademlia paper, in that
 * it ...
 * <ul>
 * <li>nodes stored have the same pre-defined prefix</li>
 * <li>there's a replacement cache of nodes (most recently seen)</li>
 * <li>allows marking a node as stale -- which will cause it to be replaced if a node becomes available in the replacement cache</li>
 * <li>allows marking a node as locked -- which will temporarily ignore it</li>
 * <li>allows splitting of a k-bucket</li>
 * </ul>
 * @author Emre Sokullu
 */
class KBucket extends \SplDoublyLinkedList
{
    const MAX = 20;

    public function push(/*mixed*/ $value): void
    {
        if($this->maxed())
            $this->shift();
        parent::push($value);
    }

    public function maxed(): bool
    {
        return ($this->count()==self::MAX);
    }
}