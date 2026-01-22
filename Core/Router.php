<?php
namespace Core;

use Storage\RedisStore;
use Security\AntiCheat;

class Router
{
    public static function dispatch(array $u, Bot $bot, RedisStore $r, array $cfg)
    {
        if (!isset($u['message'])) return;

        $m = $u['message'];
        $text = trim($m['text'] ?? '');
        $chat = $m['chat']['id'];
        $user = $m['from'];

        AntiCheat::rateLimit($user['id'], $r);

        switch ($text) {
            case '/mafia_start':
                GameManager::start($chat,$bot,$r,$cfg);
                break;
            case '/mafia_join':
                GameManager::join($chat,$user,$bot,$r);
                break;
            case '/vote':
                VoteEngine::vote($chat,$user,$bot,$r);
                break;
        }
    }
}
