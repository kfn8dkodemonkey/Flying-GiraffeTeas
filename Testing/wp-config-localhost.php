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
define('DB_NAME', 'kodemonkey');
/** MySQL database username */
define('DB_USER', 'kodemonkey');

/** MySQL database password */
define('DB_PASSWORD', 'Girlz4x42!');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
 define('AUTH_KEY',         ' BYWDs)=s6VT.l m_$/8Or,]Ur|6G5-zy1~(X)OqYB]n~hGyyQzM-l^iZ+<IL9+4');
 define('SECURE_AUTH_KEY',  'O K;Q{H6Qa~,`e]U5MWOrV&dS,MH,@=j{pzIzsd8rwDRAn-DvtB`5.,$5/_~{pu%');
 define('LOGGED_IN_KEY',    'l|<?3p}<K:MZwJ)5]_ BV-Z%Kg).C|C]@72N8)59ksjA/dJ7J7tJLSWaguzWvF:X');
 define('NONCE_KEY',        '!{c<#-_zqhFr*&g?V^E-jQuc.xNKs)hth~jx)h|BVf$$r|Y./u+G_o1DbZu:j)o-');
 define('AUTH_SALT',        'Osj8h@_MEG9glU7c%pSrqK~1RU}Y^4hh/~DLl=zC;-A*[u~@n?/-B7&fL&D*Cs~N');
 define('SECURE_AUTH_SALT', ';XVV O~G90=>si}*u6:9ll}g<j|:o`bCU> #qYr2~B}Hu6b9m)~r5!i,GL,|mJ95');
 define('LOGGED_IN_SALT',   '&>r#2j|&}^JXB@,]-:zh{HN>G,.{=E/A0_cvjuARhuY]r5N.1y6b2tclZgGdrw6Q');
 define('NONCE_SALT',       'Xo^P3usA@z|+7@HaSVk2l,s]oO:~+B]%9O7J/0 H&e.#EZVw#K&t %;%-o-v`:ts');

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

 /** FTP local host **/
 define('FS_METHOD', 'direct');

define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
