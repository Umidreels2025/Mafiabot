<?php
namespace Core;

use Storage\RedisStore;

class VoteEngine {
 public static function vote($chat,$user,Bot $bot,RedisStore $r){
  if ($r->get("g:$chat:state")!=='VOTING') return;
  $bot->send($chat,"🗳 {$user['first_name']} ovoz berdi");
 }
}
