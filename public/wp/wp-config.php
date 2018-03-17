<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'scotchbox');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '4VK(B7%`dnlaM@ ]Z0 oZ]k*TIvxfAU:f__x)qlcoejP[wCxyJe9p:m2<[2p_W,E');
define('SECURE_AUTH_KEY',  'X%][-w=u8xWl7lJrQN,PQR9*=:|>Y%9#*AL}$dp;_>Hg:*W)U=lM=*V6/#(rY7@{');
define('LOGGED_IN_KEY',    'S|Y)r:0D`Qk;@v7{0$>KJr^1tbS%.E4q+V.!?Ya,pa!c~:ipo)/7xQK+d;4-MT2c');
define('NONCE_KEY',        'iH$;:$_Pr=7wUL29^d/h,-%S6jSmU_]qTo=o3bAW1FXqBLDN,Mu]<c8Apmj>c<#5');
define('AUTH_SALT',        'ilxBDbEY(KMnTD!v6{3M+cUR>1B0%KjVH8dvoRQOz$oJE-NeK+ tJm3u*d j;RDF');
define('SECURE_AUTH_SALT', '!n(OTzf$c$xRAkHAcV)i4bR-j,O(3qok|Z#1fXGW9aCMHiBjL.@vz=EVk>5q*3jv');
define('LOGGED_IN_SALT',   'AYcG(aiN[(l);|oc:.y}@ {8U*QzR>C-QxM7p,2ezczr- +zso~LS$;hyvrs&7@M');
define('NONCE_SALT',       'l#wSD>IPjep2_^LxtpSY@h2R}1+v~OlvBo2qoY^6QzEu+L%J-AW.L+EEm)88p+(q');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
