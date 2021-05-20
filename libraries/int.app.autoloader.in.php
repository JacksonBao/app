<?php
if (ENV == 'PRODUCTION') {
    header("Content-Security-Policy: default-src 'none'; font-src 'self' https://*." . $_ENV['APP_DOMAIN'] . " https://fonts.gstatic.com;img-src 'self' blob: https://*." . $_ENV['APP_DOMAIN'] . " https://code.jquery.com https://cdnjs.cloudflare.com; object-src 'none'; script-src 'self' https://*." . $_ENV['APP_DOMAIN'] . " https://js.stripe.com https://code.jquery.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://stackpath.bootstrapcdn.com 'unsafe-inline'; style-src 'self' https://*." . $_ENV['APP_DOMAIN'] . " https://" . $_ENV['APP_DOMAIN'] . "   https://stackpath.bootstrapcdn.com https://cdnjs.cloudflare.com  https://fonts.googleapis.com 'unsafe-inline'; connect-src 'self' https://*." . $_ENV['APP_DOMAIN'] . " https://ipinfo.io;manifest-src 'self' https://*." . $_ENV['APP_DOMAIN'] . "; frame-src 'self' https://js.stripe.com");

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

} else { // for developement origin will be allowed to all
    header('Access-Control-Allow-Origin: *');
}
header('X-My-Powered-By: Njofa Developers');
header('X-XSS-Protection: 1; mode=block'); // good idea
header("Strict-Transport-Security:max-age=63072000; includeSubDomains;");
header("X-Frame-Options: sameorigin");
header("X-Content-Type-Options: nosniff");
header("Expect-CT: report-uri=https://" . $_ENV['APP_DOMAIN'] . ",enforce,max-age=6307200");
header("Feature-Policy: accelerometer *;");


include_once __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/../config/php/connect.php';

// include auto loader
spl_autoload_register(function ($class_name) {
    $explode = explode(',', str_replace('\\', ',', $class_name));
    $dir = '';
    if ($explode[0] == 'Controllers') {
        $dir = 'controllers';
    }

    $classname = end($explode);
    if ($explode[0] != 'Models') {
        array_shift($explode);
    }
    array_pop($explode);
    if (isset($explode[0]) && $explode[0] == 'Api') {
        array_unshift($explode, 'Models');
    }



    $classnameSplit = preg_split('/(?=[A-Z])/', trim($classname));
    array_shift($classnameSplit);
    if ($dir == 'controllers') {
        array_unshift($classnameSplit, 'controller');
    }

    // fix name
    $dir .= strtolower(join('/', $explode)) . '/';
    $dir = str_replace('_', '.', $dir);
    $classFile = __DIR__ . '/../' . $dir . strtolower(join('.', $classnameSplit))  . '.php';


    if (!file_exists($classFile)) {
        throw new Exception("Error Processing Request Class not found ::" . $classFile . ' ::: ' . $class_name, 1);
        exit;
    }
    include_once $classFile;
});
