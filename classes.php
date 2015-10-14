<?php
  
class classFileSystem {

    // list all files specified, and also remove invalid characters on filename
    function getFileList($dir) {       
        $files = array();
        foreach (glob("$dir") as $fileName) {
            $baseName = ereg_replace("[^0-9A-Za-z\.]", "_", basename($fileName));
            $dirName  = dirname($fileName);
            rename($fileName, "$dirName/$baseName");            
            array_push($files, "$dirName/$baseName");
        } 
        return $files;
    }
        
    function gsm2mp3($fileName) {            
        $baseName = basename($fileName);
        $dirName  = dirname($fileName);        
        $mp3Name  = str_replace('.gsm', '.mp3', $baseName);
        
        // sox needs the exact exe path
        exec("/usr/local/bin/sox -t gsm $fileName $dirName/mp3/$mp3Name");        
        rename($fileName, "$dirName/gsm/$baseName");       
    }
    
    function rebuildDirectory($cwd) {
        $oldmask = umask(0); // this is used to force the mode to 0777
        if (!file_exists("$cwd")) { mkdir("$cwd", 0777); }
        if (!file_exists("$cwd/mp3")) { mkdir("$cwd/mp3", 0777); }
        if (!file_exists("$cwd/gsm")) { mkdir("$cwd/gsm", 0777); } 
        umask($oldmask);
    }
}
