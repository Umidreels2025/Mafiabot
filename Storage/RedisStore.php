<?php
namespace Storage;

use Redis;

class RedisStore
{
    private Redis $r;

    public function __construct(array $cfg)
    {
        $this->r = new Redis();
        $this->r->connect($cfg['host'], $cfg['port']);
        $this->r->select($cfg['db']);
    }

    public function get($k)
    {
        $v = $this->r->get($k);
        return json_decode($v, true) ?? $v;
    }

    public function set($k, $v, $ttl=null)
    {
        $v = is_array($v) ? json_encode($v) : $v;
        $ttl ? $this->r->setex($k,$ttl,$v) : $this->r->set($k,$v);
    }

    public function del($k){ $this->r->del($k); }
    public function exists($k){ return $this->r->exists($k); }
}
