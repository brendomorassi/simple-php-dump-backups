<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$connections = json_decode(file_get_contents('connections.json'), true);

foreach($connections as $conn){
    dumpSaved($conn['database'], $conn['user'], $conn['pass'], $conn['host']);
}

function dumpSaved($database, $user, $pass , $host){
    $fileName = $database . '_' . date('Ymd'). '_' . date('His');
    $dir = dirname(__FILE__);

    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        if(!file_exists($dir . '\backups\\'))
            mkdir($dir.'\backups\\');

        $dir .= '\backups\\'. $fileName .'.sql';
    }else{
        if(!file_exists($dir . '/backups/'))
            mkdir($dir.'/backups/');

        $dir .= '/backups/'. $fileName .'.sql';
    }

    exec("mysqldump --user={$user} --password={$pass} --host={$host} {$database} --result-file={$dir} 2>&1", $output);
}


?>