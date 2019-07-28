<?php declare(strict_types = 1);

/*
 * This file is part of the Pho package.
 *
 * (c) Emre Sokullu <emre@phonetworks.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pho\DecentralizedComputing;

class Bucket
{
    const KeyFill = "x";

    protected $max_stores_per_bucket = 20;
    protected $hash_size = 160;

    protected $store_key_length = 0;

    public $store = [];

    protected function generateStoreKey($key)
    {
        $this->store_key_length = strlen($key);
        return str_pad(
            $key, $this->hash_size, self::KeyFill
        );
    }

    public function probe(): void
    {
        var_dump($this->store);
    }

    public function add(string $key, array $values)
    {
        $key = Helpers::hex_to_bin($key);
        $chars = str_split($key);
        $bucket_key = "";
        foreach($chars as $char) {
            $bucket_key .= $char;
            $temp_key = $this->generateStoreKey($bucket_key);
            if(!isset($this->store[$temp_key])) {
                $this->store[$temp_key] = array();
                $this->store[$temp_key][$key] = $values;
                return;
            }
            elseif(count($this->store[$tkeya])<$this->max_stores_per_bucket) {
                $this->store[$temp_key][$key] = $values;  
                return;
            }
        }
    }
}