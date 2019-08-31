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

interface IDInterface
{
    public function compareDistance(string $compare): int;

    /**
     * Returns the ID in binary format
     * with a padding ensuring it is 
     * 160 chars long.
     *
     * @return string
     */
    public function bin(): string;


}