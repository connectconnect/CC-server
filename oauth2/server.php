<?php
/**
 * Get access_token
 * @author Lazypeople<hfutming@gmail.com>
 */
define('BASE', dirname(dirname(__FILE__)));
define('OAUTH_PATH', BASE.'/oauth2/');
$config_file = BASE.'/config/config.ini';
$config = parse_ini_file($config_file, TRUE);
$db_config = $config['DataBase'];
$dsn = sprintf(
    'mysql:dbname=%s;host=%s;port=%s', 
    $db_config['dbname'], 
    $db_config['host'], 
    $db_config['port']
    );
$username  = $db_config['username'];
$password  = $db_config['password'];

ini_set('display_errors',1);
error_reporting(E_ALL);

require_once(OAUTH_PATH.'src/OAuth2/Autoloader.php');
OAuth2\Autoloader::register();

$storage = new OAuth2\Storage\Pdo(
    array(
        'dsn' => $dsn, 
        'username' => $username, 
        'password' => $password)
    );

$config = array(
            //'use_crypto_tokens'        => false,
            //'store_encrypted_token_string' => true,
            'access_lifetime'          => 5529600,//access_token失效时间
            'refresh_token_lifetime' => 0,//refresh_token失效时间
            //'www_realm'                => 'Service',
            //'token_param_name'         => 'access_token',
            //'token_bearer_header_name' => 'Bearer',
            //'enforce_state'            => true,
            //'require_exact_redirect_uri' => true,
            //'allow_implicit'           => false, //隐式认证
);
$server = new OAuth2\Server($storage,$config);

$server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage,
        array('allow_credentials_in_request_body' => false)
));

$server->addGrantType(new OAuth2\GrantType\UserCredentials($storage));

$server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));

$server->addGrantType(new OAuth2\GrantType\RefreshToken($storage, array(
        //refresh token时总是返回新的refresh_token
        'always_issue_new_refresh_token' => true,
  )));
