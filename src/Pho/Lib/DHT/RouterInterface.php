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

interface RouterInterface
{
    public function boostrap(ID $id): void;
    public function find(ID $id): PeerInterface;
    public function touch(PeerInterface $node): void;
    public function stale(PeerInterface $node): void;

}