<?php
namespace Storage;

class RedisStore
{
    private string $dir;

    public function __construct(array $cfg = [])
    {
        $this->dir = __DIR__ . '/../tmp';
        if (!is_dir($this->dir)) {
            mkdir($this->dir, 0777, true);
        }
    }

    private function path(string $key): string
    {
        return $this->dir . '/' . md5($key) . '.json';
    }

    public function get(string $key)
    {
        $file = $this->path($key);
        if (!file_exists($file)) return null;
        return json_decode(file_get_contents($file), true);
    }

    public function set(string $key, $value, int $ttl = null)
    {
        file_put_contents($this->path($key), json_encode($value));
    }

    public function del(string $key)
    {
        @unlink($this->path($key));
    }

    public function exists(string $key): bool
    {
        return file_exists($this->path($key));
    }
}