<?php
/**
 * Get access_token
 * @author Lazypeople<hfutming@gmail.com>
 */
define('BASE_ROOT', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
define('TOOLS_ROOT', BASE_ROOT . 'tools' . DIRECTORY_SEPARATOR);
define('CONFIG_ROOT', BASE_ROOT . 'config'. DIRECTORY_SEPARATOR);

// include our OAuth2 Server object
require_once __DIR__.'/server.php';

// Handle a request for an OAuth2.0 Access Token and send the response to the client
$server->handleTokenRequest(OAuth2\Request::createFromGlobals())->send();