<?php
namespace Core;

use Storage\RedisStore;

class GameManager
{
    public static function start($chat, Bot $bot, RedisStore $r, array $cfg)
    {
        if ($r->exists("g:$chat:state")) {
            $bot->send($chat,"⛔ O‘yin bor");
            return;
        }
        $r->set("g:$chat:state","WAIT");
        $r->set("g:$chat:players",[]);
        $bot->send($chat,"🎮 Mafia boshlandi\n/mafia_join");
    }

    public static function join($chat,$user,Bot $bot,RedisStore $r)
    {
        $state = $r->get("g:$chat:state");
        if ($state!=="WAIT") return;

        $p = $r->get("g:$chat:players") ?? [];
        $p[$user['id']] = $user['username'] ?? $user['first_name'];
        $r->set("g:$chat:players",$p);

        $bot->send($chat,"✅ {$p[$user['id']]} qo‘shildi (".count($p).")");

        if (count($p)>=4) {
            RoleManager::assign($chat,$bot,$r);
            FSM::set($chat,'NIGHT',$bot,$r);
            NightEngine::start($chat,$bot,$r);
        }
    }
}
