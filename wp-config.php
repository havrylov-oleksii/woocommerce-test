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
define( 'DB_NAME', 'eshop' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'pewpew12' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY', '^%:%zUA767*9|?qht9Ulm81cL~,,T]M;*2P1[FqEOz(elS5-E)!G(tE!wz>H#f@X' );
define( 'SECURE_AUTH_KEY', 'WsGN;ym_W2>?cluP5o)A+|thF-O_IGxO^QLeq)`Ox_Y!-Ck[=e-}=?!c#,h)oz^o' );
define( 'LOGGED_IN_KEY', 'YCk/rv/#MMAIe0kDU-y9<24!b|6hvIoj}ar+1o@nvp=oLVr6R#_alk:bOG9+WW70' );
define( 'NONCE_KEY', 'JbWwq/V.D0}=<ufGid>JxCV]zqQ.Wm8%_EyRW[f y$ybEVat`?YlFPyJdFXH*|mQ' );
define( 'AUTH_SALT', '9zwsMly047bo0$+5+:shSk8ztpO$<B!kpX91Uk?PEYC?2<85)~K9ofEBEu<hi%|~' );
define( 'SECURE_AUTH_SALT', 'pC(Ax]I7Q9wg/ZxdJ[7lkWaOpg#r|!3]A|:1`f}/L,379%h/vee$5|%$jJ8Kucr@' );
define( 'LOGGED_IN_SALT', '[&)q?[h [S@viZ~{U!dHHyk{xxrl}AusykBf)@]_3VF{u5(!^.GEoZI q7]kzxo`' );
define( 'NONCE_SALT', '+}zG_WY;W^4r{Qh>Z>Z|v:45eKrD:Vd^1?mx(2T:[YNel04{<!U~]T8HS/rW>icm' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', true );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
