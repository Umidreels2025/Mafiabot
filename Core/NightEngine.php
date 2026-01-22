<?php
namespace Core;

use Storage\RedisStore;

class NightEngine {
 public static function start($chat,Bot $bot,RedisStore $r){
  sleep(90);
  // resolve minimal
  $bot->send($chat,"🌅 Tun tugadi");
  FSM::set($chat,'VOTING',$bot,$r);
 }
}
