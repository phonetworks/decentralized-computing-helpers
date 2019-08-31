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

use BCMathExtended\BC as BCe;

class IDMock implements IDInterface
{
    const BitLength = 160;
    const ByteLength = (self::BitLength / 8);
    protected $id; // in hex

    public function __construct(string $id = "")
    {
        if(empty($id))
            $id = $this->generate();
        $this->id = $id;
    }

    public function __toString(): string
    {
        return $this->id;
    }

    /**
     * Generates a cryptographically secure random Id
     * 
     * Completely random
     * better for security
     * To use as key and node ID
     * 160 bits, e.g. 20 bytes
     *
     * @return string
     */
    protected function generate(): string
    {
        $id = \bin2hex(
            \random_bytes(
                (self::ByteLength)
            )
        );
    }

    /**
     * {@inheritDoc}
     */
    public function distance($compare): int
    {
        return Utils::xor_distance($this->id, $compare);
    }

    /**
     * {@inheritDoc}
     */
    public function bin(): string
    {
        return Utils::hex_to_bin($this->id, self::BitLength);
    }


}