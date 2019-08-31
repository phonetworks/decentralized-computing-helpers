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
    /**
     * Forms the RouteTree objects
     *
     * @return void
     */
    public function boostrap(): void;
    // public function __construct(ID $base_id, int $branches_per_level, int $max_nodes_per_bucket, int $max_cache_nodes_per_bucket);
    public function find(ID $id, int $max, bool $include_stale): array;
    public function touch(PeerInterface $node): void;
    public function stale(PeerInterface $node): void;

}