<?php

header('X-My-Powered-By: Njofa World');
header('X-XSS-Protection: 1; mode=block'); // good idea
header("Strict-Transport-Security:max-age=63072000; includeSubDomains;");
header("X-Frame-Options: sameorigin");
header("X-Content-Type-Options: nosniff");
header("Expect-CT: report-uri=https://".$_ENV['APP_DOMAIN'].",enforce,max-age=6307200");
header("Feature-Policy: accelerometer *;");



// include files
function isOriginAllowed($incomingOrigin, $allowOrigin = $_ENV['APP_DOMAIN'])
{
    $count = strlen(trim($allowOrigin));
    $check = substr($incomingOrigin, -$count);
    if ($check == $allowOrigin) {
        return true;
    } else {
        return false;
    }
}

$incomingOrigin = array_key_exists('HTTP_ORIGIN', $_SERVER) ? $_SERVER['HTTP_ORIGIN'] : NULL;
$allowOrigin = $_SERVER['SERVER_NAME'];

if ($incomingOrigin !== null && isOriginAllowed($incomingOrigin) == true) {
    header("Access-Control-Allow-Origin: " . $incomingOrigin);
}


include_once __DIR__ . '/../config/php/connect.php';
include_once __DIR__ . '/../config/php/paths.php';
include_once __DIR__ . '/../config/php/routes.php';

$traits = scandir(__DIR__ . '/../libraries/traits');
if(count($traits) > 0){
    foreach ($traits as $key => $trait) {
        $exp = explode('.', $trait);
        $ext = end($exp);
        if($ext == 'php'){
            include_once __DIR__ . '/../libraries/traits/' . $trait;
        }
    }
}

$traits = scandir(__DIR__ . '/../libraries/extends');
if(count($traits) > 0){
    foreach ($traits as $key => $trait) {
        $exp = explode('.', $trait);
        $ext = end($exp);
        if($ext == 'php'){
            include_once __DIR__ . '/../libraries/extends/' . $trait;
        }
    }
}


include_once __DIR__ . '/../libraries/int.app.functions.php';
include_once __DIR__ . '/../libraries/int.app.controllers.php';
include_once __DIR__ . '/../libraries/int.app.models.php';
include_once __DIR__ . '/../libraries/int.app.bootstrap.php';
