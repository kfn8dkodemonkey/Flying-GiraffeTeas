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
define('DB_NAME', 'fly1903809080769');

/** MySQL database username */
define('DB_USER', 'fly1903809080769');

/** MySQL database password */
define('DB_PASSWORD', 'Girlz4x42!');

/** MySQL hostname */
define('DB_HOST', 'fly1903809080769.db.8005659.c9b.hostedresource.net');

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
define('AUTH_KEY',         'MFZ%If$ *0vFJvx@kd5J');
define('SECURE_AUTH_KEY',  '9nG$9nxXRcEYRLmkpwmr');
define('LOGGED_IN_KEY',    'g(45C12Uh38*TNfv93gC');
define('NONCE_KEY',        'A Z=&Em&Epdt!L 1Y)Cz');
define('AUTH_SALT',        'Q$0rZD22hJYq)H4P&nT%');
define('SECURE_AUTH_SALT', 'wJgfSCkc/!$k2F+m2Qz@');
define('LOGGED_IN_SALT',   'j%OXbha3zEzIh)*ACmC9');
define('NONCE_SALT',       '#1cCF-m0DtHdk=@Ipz(W');

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
