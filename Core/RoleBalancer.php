<?php
namespace Core;

class RoleBalancer {
 public static function make($n){
  $r=[Roles::MAFIA,Roles::KOMISSAR,Roles::DOCTOR];
  while(count($r)<$n) $r[]=Roles::CIVIL;
  shuffle($r);
  return $r;
 }
}
