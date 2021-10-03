<?php

use WHMCS\Database\Capsule;

//
// various log garbage collection, done daily
//
// this script run daily, at a given hour you can define at your own in line 18, and remove from logs various unuseful stuff 
// in line  to  you have various examples of queries to purge different logs:
// whoislog: removes every record oldest than 3 days
// activitylog: removes "automated task starting", "Domain Sync Cron completed" and "Cron running" records oldest than 2 days
// You can add further queries to clean other kind of logs, used by addon or registrar module (i.e. in rows 23 to 25 you have code examples to clean dns_manager2_log, useful only if
// you're using the DNS Manager Addon module by Modulesgarden
// You can customize the number of days any kind of record is retained before deleting it (  strtotime('-2 days'),  strtotime('-3 days') , strtotime('-5 days') etc.)

function logcleaner($vars) {
  
    if (date('H') == '17' && intval(date('i')) < 5) {
       $deletedtblwhoislog=Capsule::table('tblwhoislog')->where('date', '<',date('Y-m-d', strtotime('-3 days')))->delete();
       $deletedtblactivitylog=Capsule::table('tblactivitylog')->where('date', '<',date('Y-m-d', strtotime('-2 days')))->where('description','LIKE','%Automated Task: Starting%')->delete();
       $deletedtblactivitylog2=Capsule::table('tblactivitylog')->where('date', '<',date('Y-m-d', strtotime('-2 days')))->where('description','LIKE','%Domain Sync Cron: Completed%')->delete();
       $deletedtblactivitylog3=Capsule::table('tblactivitylog')->where('date', '<',date('Y-m-d', strtotime('-2 days')))->where('description','LIKE','%Cron running at%')->delete(); 
//       $deletedtbldns1=Capsule::table('dns_manager2_log')->where('date', '<',date('Y-m-d', strtotime('-2 days')))->where('value','LIKE','Cron Log Cleaner Started')->delete(); 
//       $deletedtbldns2=Capsule::table('dns_manager2_log')->where('date', '<',date('Y-m-d', strtotime('-2 days')))->where('value','LIKE','Cron Cleaner Started')->delete(); 
//       $deletedtbldns3=Capsule::table('dns_manager2_log')->where('date', '<',date('Y-m-d', strtotime('-2 days')))->where('value','LIKE','Cron Status Zone Started')->delete(); 
       
      logActivity('log cleaning: tblwhoislog deleted '.$deletedtblwhoislog.' records - tblactivitylog deleted '.($deletedtblactivitylog+$deletedtblactivitylog2+$deletedtblactivitylog3).' records - dns_manager2_log deleted '.($deletedtbldns1+$deletedtbldns2+$deletedtbldns3).' records');
    }  
}

add_hook("AfterCronJob",5,"logcleaner");
