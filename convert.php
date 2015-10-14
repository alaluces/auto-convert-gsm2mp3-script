#!/usr/bin/php -q
<?php 

// 20151014
// Auto GSM to MP3 Converter 
// Uses Cron, Samba and Sox
//
// runs every 2 minutes via cron
// */2 * * * * /root/auto_convert/convert.php >/dev/null 2>&1

require 'classes.php';

$fs  = new classFileSystem();

$cwd = '/shared/public/converter';
// Rebuild the directory structure if somebody deleted them
$fs->rebuildDirectory($cwd);
echo "Processing folder $cwd\n";

// Get all GSM files 
$gsmList = $fs->getFileList("$cwd/*.gsm");

// Convert
if (count($gsmList) > 0){
    for($i=0; $i < count($gsmList);$i++){  
        $fs->gsm2mp3($gsmList[$i]);
    }   
}