<?php
namespace Utils;

class Logger {
 public static function log($m){
  file_put_contents('bot.log',date('c').' '.$m."\n",FILE_APPEND);
 }
}
