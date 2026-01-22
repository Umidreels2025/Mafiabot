<?php
namespace Security;

use Storage\RedisStore;

class AntiCheat {
 public static function rateLimit($uid,RedisStore $r){
  $k="rl:$uid";
  $c=$r->get($k)??0;
  if($c>20) die();
  $r->set($k,$c+1,60);
 }
}
