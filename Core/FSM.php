<?php
namespace Core;

use Storage\RedisStore;

class FSM {
 public static function set($chat,$state,Bot $bot,RedisStore $r){
  $r->set("g:$chat:state",$state);
  $bot->send($chat,"⏭ Bosqich: $state");
 }
}
