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

use Pho\Lib\DHT\Mocks\{ID, Peer};
use Pho\Lib\DHT\Router;

/**
 * Test Foundation
 * 
 * @author Emre Sokullu <emre@phonetworks.org>
 */
class TestCase extends \PHPUnit\Framework\TestCase 
{
    protected $faker;
    protected $network;
    protected $network_id;
    protected $peers = [];
    protected $tree;
    protected $keys;

    public function setUp()
    {
        $this->faker = \Faker\Factory::create();
    }

    public function destroy()
    {
        $this->network = null;
        $this->network_id = null;
        $this->peers = [];
        $this->tree = null;
        $this->keys = [];
    }

    protected function _testX(int $limit, array $seeds = array(), bool $inspect = false, $bucket_size = 20)
    {
        $network_ip = $this->faker->ipv4;
        $network_port = rand(80, 9000);
        $network_peer = new Peer($network_ip, $network_port);
        $this->network_id = $network_peer->id();
        $this->network = new Router($network_peer, $seeds, ["debug"=>true, "kbucket_size"=> $bucket_size]);
        $this->network->bootstrap();
        if($inspect)
            eval(\Psy\sh());
        for($i=0;$i<$limit;$i++) {
            $this->peers[$i] = new Peer($this->faker->ipv4, rand(80, 9000));
            $this->network->touch($this->peers[$i]);
        }
        $this->tree = $this->network->tree();
        $this->keys = array_keys($this->tree);

        return [
             $this->network,
             $this->network_id,
             $this->peers,
             $this->tree,
             $this->keys
        ];
        
    }   

    /**
     * Sorts an array
     * 
     * Because \sort passes by reference
     *
     * @param array $array
     * @return array
     */
    protected static function sort(array $array): array
    {
        sort($array);
        return $array;
    }

    protected static function array_flatten(?array $array = null): array 
    {
        $result = array();
    
        if (!is_array($array)) {
            $array = func_get_args();
        }
    
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, self::array_flatten($value));
            } else {
                $result = array_merge($result, array($key => $value));
            }
        }
    
        return $result;
    }

}