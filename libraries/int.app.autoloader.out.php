<?php

header('X-My-Powered-By: Njofa World');
header('X-XSS-Protection: 1; mode=block'); // good idea
header("Strict-Transport-Security:max-age=63072000; includeSubDomains;");
header("X-Frame-Options: sameorigin");
header("X-Content-Type-Options: nosniff");
header("Expect-CT: report-uri=https://njofa.com,enforce,max-age=6307200");
header("Feature-Policy: accelerometer *;");



// include files
function isOriginAllowed($incomingOrigin, $allowOrigin = 'njofa.com')
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


include_once 'config/php/app.db.connect.php';
include_once 'config/php/construct.app.paths.php';
include_once 'config/php/app.file.system.php';
include_once 'config/php/app.authenticate.php';

include_once 'libraries/traits/app.view.traits.php';
include_once 'libraries/traits/app.metatag.traits.php';
include_once 'libraries/traits/app.error.traits.php';
include_once 'libraries/traits/app.validate.form.traits.php';
include_once 'libraries/traits/app.file.handler.traits.php';
include_once 'libraries/traits/app.email.templates.php';
include_once 'libraries/extends/ext.image.resize.exception.php';
include_once 'libraries/extends/ext.image.resize.php';

include_once 'libraries/int.app.functions.php';
include_once 'libraries/int.app.controllers.php';
include_once 'libraries/int.app.models.php';
include_once 'libraries/int.app.bootstrap.php';
