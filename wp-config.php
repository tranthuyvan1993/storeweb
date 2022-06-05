<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'bhn' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'M7JxUc}p6X#m$(-$}7Kg>3_H$e{/l3j[)05RD=>L.*wk6,23y`/_yWlR9rK9h?;y' );
define( 'SECURE_AUTH_KEY',  '%5lWqh]3N-<rh+02!Hr(H?hKfY0WoT3i&#-(Qz@m0W?d[heS>gsdqQ/`Bo:<G<3+' );
define( 'LOGGED_IN_KEY',    'Vg*.KBs&Mt=2o,3%!GZN##I4(3o*?R1`cDm`%Im1g8]F!bWQyO~BJ>DHy2Mn%gcF' );
define( 'NONCE_KEY',        '2N0Fvm3jNIi#j*~nhNfYZw)w2>d%e:JWE1k7~Yu<*D<!|cw[z7}ws+Uv*cB#}=-&' );
define( 'AUTH_SALT',        '5Tg^|dNMCu.otZTd.D`foPf4m.v,JJs.EmFHHiV(Hcfqj{C~U&C08SO Hi5,lZ45' );
define( 'SECURE_AUTH_SALT', 'sl/r7hLud2(xeJfAk]0EX~b9MhXJ5vAU/eptbb~f< Us3SFFPA-w@oQp27gz1Sk6' );
define( 'LOGGED_IN_SALT',   '$FMaggnyse&Q-XfZQ|GKHLdnUC!,*?-ph/uexF2b:4I*7AVHV]boI-+KsW?10N.>' );
define( 'NONCE_SALT',       'V,h=f4i+YD!,9bZK$~v/xOIP$=fCOk;>?N[(A0D.VM;7Nl^[<vyeR{&g!l8)O)8S' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
