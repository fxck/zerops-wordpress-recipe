<?php
define( 'DB_NAME', getenv('WORDPRESS_DB_NAME') );
define( 'DB_USER', getenv('WORDPRESS_DB_USER') );
define( 'DB_PASSWORD', getenv('WORDPRESS_DB_PASSWORD') );
define( 'DB_HOST', getenv('WORDPRESS_DB_HOST') );
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

$table_prefix = 'wp_';

define('WP_SITEURL', getenv('WORDPRESS_URL'));
define('WP_HOME', getenv('WORDPRESS_URL'));

define( 'WP_DEBUG', false );

if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

define('FORCE_SSL_ADMIN', true);

if ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
  $_SERVER['HTTPS']='on';
}

require_once( ABSPATH . 'wp-settings.php' );
