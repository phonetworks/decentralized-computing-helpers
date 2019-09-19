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

interface IDInterface
{
    /**
     * Computes XOR distance between two Ids
     * 
     * @link https://stackoverflow.com/questions/27081124/binary-separation-distance-java
     * 
     * @param mixed $another_id either another IDInterface or string (in hex format)
     * 
     * @return string The distance  (string because it may be a bignum)
     */
    public function distance(/*mixed*/ $another_id): string;

    /**
     * Returns the ID in binary format
     *
     * @return string
     */
    public function bin(): string;


}
