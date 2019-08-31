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

class RouterMock implements RouterInterface
{

    protected $tree;
    protected $id;

    public function __construct(ID $id)
    {
        $this->id = $id;
        $this->tree = new RouterTree;
    }

    public function bootstrap(): void
    {

    }

    public function touch(PeerInterface $peer)
    {
        $key = $peer->id()->bin();
        $chars = str_split($key);
        $bucket_key = "";
        foreach($chars as $char) {
            $bucket_key .= $char;
            $temp_key = RouteTree::formKey($bucket_key);
            if(!isset($this->tree[$temp_key])) {
                $this->tree[$temp_key] = new KBucket;
                $this->rebalanceTop($temp_key);
            }
            if(!$this->tree[$temp_key]->maxed()) {
                $this->tree[$temp_key]->push($peer);
                break;
            }
        }
    }

    protected function rebalanceTop(string $key): void
    {
        $clean_new_key = RouteTree::getCleanKey($key);
        $upper_key = RouteTree::getUpperKey($key);
        if(empty($upper_key))
            return;
        foreach($this->store[$upper_key] as $i=>$peer) {
            if(strpos($peer->id(), $clean_new_key)===0) {
                $this->store[$upper_key]->offsetUnset($i);
                $this->store[$key]->push($peer);
            }
        }
        $this->rebalanceTop($upper_key);
    }

}