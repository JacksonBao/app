<?php
define('ENV', '');
define('APP', 'WALLET');
define('WALLET_APP_FOLDER', 'wallet.app');
define('WALLET_APP_NAME', 'Njofa Market v8');
define('WALLET_APP_ROOT', $_SERVER['DOCUMENT_ROOT']);
define('WALLET_CURRENT_PATH', getcwd());
define('WALLET_DEFAULT_APP_PATH', '');
define('WALLET_SITE_URL', 'http://' . $_SERVER['SERVER_NAME']);
define('lang', 'en');

define('WALLET_DEFAULT_CURRENCY', 'USD');

define('WALLET_FILE_ROOT', str_replace(WALLET_APP_FOLDER, 'image.app', WALLET_APP_ROOT));
define('PARENT_ROOT', str_replace(WALLET_APP_FOLDER, '', WALLET_APP_ROOT));
define('PARENT_URL', 'http://localhost/njofa');
@define('FILE_DOMAIN', 'http://im.njofa.dv/');
