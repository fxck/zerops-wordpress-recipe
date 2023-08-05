<?php
// database
define( 'DB_NAME', getenv('WORDPRESS_DB_NAME') );
define( 'DB_USER', getenv('WORDPRESS_DB_USER') );
define( 'DB_PASSWORD', getenv('WORDPRESS_DB_PASSWORD') );
define( 'DB_HOST', getenv('WORDPRESS_DB_HOST') );
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );
$table_prefix = getenv('WORDPRESS_TABLE_PREFIX');

// auth
define( 'AUTH_KEY', getenv('WORDPRESS_AUTH_KEY') );
define( 'SECURE_AUTH_KEY', getenv('WORDPRESS_SECURE_AUTH_KEY') );
define( 'LOGGED_IN_KEY', getenv('WORDPRESS_LOGGED_IN_KEY') );
define( 'NONCE_KEY', getenv('WORDPRESS_NONCE_KEY') );
define( 'AUTH_SALT', getenv('WORDPRESS_AUTH_SALT') );
define( 'SECURE_AUTH_SALT', getenv('WORDPRESS_SECURE_AUTH_SALT') );
define( 'LOGGED_IN_SALT', getenv('WORDPRESS_LOGGED_IN_SALT') );
define( 'NONCE_SALT', getenv('WORDPRESS_NONCE_SALT') );

// settings
define('WP_SITEURL', getenv('WORDPRESS_URL'));
define('WP_HOME', getenv('WORDPRESS_URL'));

// debug
define( 'WP_DEBUG', getenv('WORDPRESS_DEBUG') );
define( 'WP_DEBUG_DISPLAY', getenv('WORDPRESS_DEBUG_DISPLAY') );

// plugins
define( 'AS3CF_SETTINGS', serialize(
  array(
    'provider' => 'aws',
    'access-key-id' => '********************',
    'secret-access-key' => '**************************************',
    'bucket' => 'mybucket'
  )
) );

// misc
define('FORCE_SSL_ADMIN', true);

if ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
  $_SERVER['HTTPS']='on';
}

if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

require_once( ABSPATH . 'wp-settings.php' );
