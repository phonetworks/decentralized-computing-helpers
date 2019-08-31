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

class NodeMock implements NodeInterface
{

    protected $id;
    protected $buckets;

    public function __construct()
    {
        $this->buckets = new \SplFixedArray(160);
        $this->id = ID::generate();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function store(string $key, ContactInterface $contact): void
    {
        $proximity = Utils::xor_distance($this->id, $contact->id());
        if(!isset($this->buckets[$proximity])) {
            $this->buckets[$proximity] = new Bucket; 
        }
        $this->buckets[$proximity]->push($contact);
        $this->ping($contact);
    }

    public function ping(ContactInterface $contact): void
    {
        for($i=0;$i<4;$i++)
        {
            foreach($this->buckets[$i] as $contact)
            {
                $contact->store($contact); // ?
                // kac tane depth
            }
        }
    }

}