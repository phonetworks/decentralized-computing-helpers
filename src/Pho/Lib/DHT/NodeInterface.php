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

interface NodeInterface
{
    /**
     * Finds a Node given its ID
     *
     * @param string $id
     * 
     * @return void
     */
    public function findNode(string $id): void;

    /**
     * Stores a new Contact in the 
     * Buckets.
     *
     * @param string $id
     * @param Contact $contact
     * 
     * @return void
     */
    public function store(string $id, Contact $contact): void;

    /**
     * Let the Contacts know that there has been
     * a new storage.
     *
     * @return void
     */
    public function ping(Contact $contact): void;
}