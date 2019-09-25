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

class Router extends \Sabre\Event\Emitter implements RouterInterface
{
    const TIMEOUT = 1.5;
    const CONFIGURABLES = [
        "kbucket_size",
        "bit_length",
        "debug",
        "parallel_search"
    ];
    
    protected $seeds;
    protected $id;
    protected $connector;
    protected $tree = array();
    protected $kbucket_size = 20;
    protected $bit_length = 128;
    protected $debug = false;
    protected $parallel_search = 3;
    

    /**
     * Constructor
     *
     * @param string $id
     * @param array $seeds in the form [id<string>=>PeerInterface]
     * @param array $params 
     */
    public function __construct(PeerInterface $self, array $seeds = [], array $params = [])
    {
        parent::__construct(); //  Sabre\Event\Emitter
        $this->seeds = $seeds;
        foreach(self::CONFIGURABLES as $configurable)
        {
            if(isset($params[$configurable])) {
                $this->$configurable = $params[$configurable];
            }
        }
        $this->handle();
    }

    /**
     * {@inheritDoc}
     */
    public function id(): string
    {
        return (string) $this->id;
    }

    protected function handle(): void 
    {
        $this->on("ping", function(string $id, string $ip, int $port) {
            $this->touch(["ip"=>$ip, "port"=>(int) $port, "id"=>$id]);
            // return "PONG\n";
        });
        $this->on("find_peer", function(string $id) {
            $hops = $this->findPeers($id);
            if($hops instanceof PeerInterface)
            {
                return [
                    "success"=>true,
                    "ip" => $hops->ip(),
                    "port" => $hops->port()
                ];
            }
            $return = [];
            $i = 0;
            foreach($hops as $peer) {
                $return[$i++] = [
                    "id"   => (string) $peer->id(),
                    "port" => $peer->port(),
                    "ip"   => $peer->ip()
                ];
            }
            return [
                "success" => false,
                "check" => $return
            ];
        });
    }

    

    /**
     * {@inheritDoc}
     */
    public function bootstrap( PeerInterface $self ): void
    {
        $this->id = (string) $self->id();
        $this->tree = new RouteTree((string) $this->id, $this->kbucket_size, $this->bit_length, $this->debug);
        $this->touch($self);
        foreach($this->seeds as $peer) {
            $this->touch($peer);
            $this->ping($peer);
        }
    }

    public function stale(/*mixed*/ $entity): void
    {

    }

    public function findValue(string $key)
    {

    }

    /**
     * {@inheritDoc}
     */
    public function touch(/*mixed*/ $entity): void
    {
        if(!($entity instanceof PeerInterface) && is_array($entity)) {
            //  ip, port, id
            //echo "creating entity";
            $entity = new PeerMock($entity["ip"], $entity["port"], $entity["id"]);
            //echo "it's done";
            //var_dump($this->tree->toArray());
        }
        $this->tree->push($entity);
    }

     /**
     * {@inheritDoc}
     */
    public function ping(PeerInterface $peer): bool
    {
        /*
        $uri = $peer->ip().":".$peer->port();
        $this->connector->connect($uri)->then(function (\React\Socket\ConnectionInterface $conn) use ($data) {
            $conn->write("PING\n");
            echo "ping'ledim\n";
            $conn->on('data', function ($data) use ($conn) {
                if(trim($data)=="PONG")
                    echo "pong aldim\n";
                $conn->close();
            });
            //$conn->end();
        });
        return true;
        */
        /*
        $uri = "127.0.0.1:9000";
        $loop = \React\EventLoop\Factory::create();
        $connector = new \React\Socket\Connector($loop,[]);
        $connector->connect($uri)->then(function (\React\Socket\ConnectionInterface $conn) {
            $conn->write("PING\n");
            echo "ping'ledim\n";
            $conn->on('data', function ($data) use (&$conn) {
                if(trim($data)=="PONG")
                    echo "pong aldim\n";
                $conn->close();
            });
        });
        $loop->run();
        */

        /*
        $ping = new \JJG\Ping($peer->ip());
        $ping->setTimeout(self::TIMEOUT);
        $latency = $ping->ping();
        return ($latency !== false);
        */

        $uri = $peer->ip().":".$peer->port();
        $loop = \React\EventLoop\Factory::create();
        $connector = new \React\Socket\Connector($loop,[
            'timeout' => self::TIMEOUT
        ]);
         $connector->connect($uri)->then(
             function (\React\Socket\ConnectionInterface $conn) use ($peer) {
                echo "in";
                $conn->write("PING {$this->id()}\n");
                echo "ping'ledim\n";
                $conn->on('data', function ($data) use (&$conn, $peer) {
                    if(trim($data)=="PONG")
                        echo "pong aldim\n";
                    $this->touch($peer);
                    $conn->close();
                });
             },
            function (\Exception $error) {
                // failed to connect due to $error
                echo "PONG ALAMADIM!";
            }
        );
 $loop->run();
        return true;
    }



    public function lookup(string $id)
    {

    }

    public function findPeer(string $id): PeerInterface
    {
        $key = Utils::xor_bucket($id, (string) $this->id);
        $bucket = $this->getNearestBucket($key);
        if(($n=$bucket->has($id))!=-1)
            return $bucket[$n];
        $peer = $bucket->getActive();
        return $peer;
    }

    public function findPeers(string $id, int $skip = 0)
    {
        $key = Utils::xor_bucket($id, (string) $this->id);
        try { 
            $bucket = $this->getNearestBucket($key, $skip);
        } catch(\Exception $e) {
            return null;
        }
        if(($n=$bucket->has($id))!=-1)
            return $bucket[$n];
        $peers = iterator_to_array($bucket->getActives($this->parallel_search));
        $remaining = $this->parallel_search - count($peers);
        if($remaining>0) {
            $x = $this->findPeers($id, ($skip+1));
            if($x instanceof PeerInterface)
                return $x;
            if(!is_null($x)) {
                for($i=0;$i<$remaining;$i++) {
                    $peers[] = $x[$i];
                }
            }
        }
        return $peers;
    }

    public function tree(): ?array
    {
        if(!$this->debug)
            return null;
        return $this->tree->toArray();
    }

    public function dumpTree(): ?array
    {
        if(!$this->debug)
            return null;
        return $this->tree->dump();
    }

    public function getNearestBucket(string $distance, int $skip = 0): KBucket
    {
        return $this->tree->kbucket(
                (string) $this->findNearestBucket($distance, $skip)
        );
    }
    

    /**
     * Find Nearest Bucket
     * 
     * @param integer $distance
     * @return void
     */
    public function findNearestBucket(string $distance, int $skip = 0): int
    {
        $i=$j= (int) $distance;
        while(($i>0||$j<$this->bit_length)) {
            if($this->tree->has($i)) {
                if($skip==0)
                    return $i;
                $skip--;    
            }
            else if($this->tree->has($j)) {
                if($skip==0)
                    return $j;
                $skip--;
            }
            $i--;
            $j++;
        }
        throw new \Exception("No nearest bucket, meaning no seeds, or must have ran a second time with little data");
    }

}