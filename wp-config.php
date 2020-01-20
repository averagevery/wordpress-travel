<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

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
define( 'DB_NAME', 'MundoData' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'QZ7`N#=b!=JaNn;9Sya1ix0@]B{{|wR/A0AS}n} c;y#$J_VJtN<9})=NQ ~I!0u' );
define( 'SECURE_AUTH_KEY',  '@Qt`diE9qi~T)QOk_lhvlYvHX4s*a{|u M2i;MjuCx(oio@`A2.L6=nl(vvIT<bS' );
define( 'LOGGED_IN_KEY',    ':b29)ouv7HzE1z$h(/a@cAE:V,Z6xT]$e:C8}>)^lx4pUFHL>LoPIJUE-i],M4+h' );
define( 'NONCE_KEY',        ':zK/W+7F9k0mm^Q)+{S>+G`$#=p@B IB<H0:TozBXM}lpD?p4wE@_]l7%te/G57H' );
define( 'AUTH_SALT',        '^lI]kjsMyy9f789{_O>j=&a`.(95#!C,&fRp:4Ls#)GSAM_k^xsJ>exiOC%wB!d.' );
define( 'SECURE_AUTH_SALT', 'J_ 7g/zv?d~A.s8Z=iHT?>,bW*FE7g@4#;* j+RZ3omk*~1xs_j(=T#D{Oy>9B*b' );
define( 'LOGGED_IN_SALT',   'r39pKZC :+6;.G.8Sw3ZVb:yln~pR<~dO[I8$s,mW-}TkRMtXiEG_T)B=/6>3(xH' );
define( 'NONCE_SALT',       '8_{6*,IA1Z+6EzLGAb3Xzr,}mI%DI/1.Ar+J%b.qAJ`;;iW3vt@})D6|$)gQ7pxP' );

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
