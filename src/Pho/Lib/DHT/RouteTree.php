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
 * An implementation of Kademlia's route tree. This is an implementation of a <b>strict</b> route tree, meaning that it doesn't perform
 * the irregularly bucket splitting mentioned in the original Kademlia paper. The portion of the paper that deals with irregular bucket
 * splitting was never fully understood (discussion on topic can be found here: http://stackoverflow.com/q/32129978/1196226).
 * <p>
 * A strict route tree is a route tree that is static (doesn't split k-buckets after creation) and extends all the way done to your own
 * ID. For example, the route tree of node 000 would look something like this (assuming that the route tree branches only 1 bit at a
 * time)...
 * <pre>
 *                0/\1
 *                /  [1xx BUCKET]
 *              0/\1
 *              /  [01x BUCKET]
 *            0/\1
 *       [SELF]  [001 BUCKET]
 * </pre>
 * @author Emre Sokullu
 */
class RouteTree
{
    const KeyFill = "x";
    const HashSize = 160;

    public static function formKey(string $prefix): string
    {
        return str_pad(
            $prefix, self::HashSize, self::KeyFill
        );
    }

    public static function getCleanKey(string $key): string
    {
        return str_replace(self::KeyFill, "", $key);
    }

    public static function getUpperKey(string $key): string
    {
        $pos = strpos($key, self::KeyFill);
        if($pos <= 1)
            "";
        $upper_key = $key;
        $upper_key[($pos-1)] = self::KeyFill;
        return $upper_key;
    }


}