<?php
namespace Core;

use Storage\RedisStore;

class Bot
{
    private string $token;
    private string $api;
    private RedisStore $redis;
    private array $config;

    public function __construct(array $config, RedisStore $redis)
    {
        $this->token = $config['telegram']['token'];
        $this->api   = $config['telegram']['api'];
        $this->redis = $redis;
        $this->config = $config;
    }

    public function run()
    {
        $offset = 0;
        while (true) {
            $updates = $this->request('getUpdates', [
                'offset' => $offset,
                'timeout' => 30
            ]);
            foreach ($updates['result'] ?? [] as $u) {
                $offset = $u['update_id'] + 1;
                Router::dispatch($u, $this, $this->redis, $this->config);
            }
        }
    }

    public function send($chatId, string $text)
    {
        $this->request('sendMessage', [
            'chat_id' => $chatId,
            'text' => $text
        ]);
    }

    private function request(string $method, array $data)
    {
        $ch = curl_init($this->api.$this->token.'/'.$method);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $data
        ]);
        $res = curl_exec($ch);
        curl_close($ch);
        return json_decode($res, true);
    }
}
