<?php

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
 * Constants
 * 
 * @author Emre Sokullu <emre@phonetworks.org>
 */
class Constants
{
    /**
     * Returns default seed peers
     *
     * @return array
     */
    public static function seeds(): array
    {
        return [
            new Seed("https://accounts.graphjs.com", "07660876-C7E1-44A4-86C3-754799733FF0"),
            new Seed("https://accounts.groups2.com", "16D58CF2-FD88-4A49-972B-6F60054BF023"),
        ];
    }
}