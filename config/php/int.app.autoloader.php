<?php

if(!isset($WALLET_ROOT_PATH)){$WALLET_ROOT_PATH = '';}

include_once $WALLET_ROOT_PATH . 'config/php/app.db.connect.php';
include_once $WALLET_ROOT_PATH . 'config/php/app.construct.paths.php';
include_once $WALLET_ROOT_PATH . 'config/php/app.file.system.php';
include_once $WALLET_ROOT_PATH . 'config/php/app.authenticate.php';

include_once $WALLET_ROOT_PATH . 'libraries/traits/app.tables.traits.php';
include_once $WALLET_ROOT_PATH . 'libraries/traits/app.error.traits.php';
include_once $WALLET_ROOT_PATH . 'libraries/int.app.functions.php';
