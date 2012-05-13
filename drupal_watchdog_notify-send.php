#!/usr/bin/php5
<?php
require("config.php");

$watchdog_levels = array('Emergency','Alert','Critical','Error','Warning','Notice','Info','Debug');

$raw = get_last_watchdog();
$last = array_pop($raw);
unset($raw);
while(1){
  $data = get_last_watchdog($last->wid);
  if(count($data)){
    $last = $data[0];
    foreach(array_reverse($data) as $dog){
      $summary = "[".$watchdog_levels[$dog->severity]."] ".$dog->type;
      $body = $dog->message;
      $exe = 'notify-send --icon='.getcwd().'/druplicon.vector.svg \''.addslashes($summary).'\' \''.addslashes($body).'\'';
      passthru($exe);
    }
  }
  if(isset($run_sleep)){
    sleep($run_sleep);
  } else {
    sleep(1);
  }
}

echo "\n";

function get_last_watchdog($lastid=null){
  $link = mysql_connect(mysql_host,mysql_user,mysql_password) or die("connect error:".mysql_error());
  mysql_select_db(mysql_database) or die("select_db error");
  if(isset($lastid)){
    $query = "SELECT * FROM watchdog WHERE `wid` > $lastid ORDER BY `wid` DESC";
  } else {
    $query = "SELECT * FROM watchdog ORDER BY `wid` DESC LIMIT 1";
  }
  $result = mysql_query($query) or die("query error:".mysql_error());
  $data = array();
  while($line = mysql_fetch_object($result)){
    $data[] = $line;
  }
  mysql_free_result($result);
  mysql_close($link);
  return $data;
}
