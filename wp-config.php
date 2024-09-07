<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'addwebsolution_db' );

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
define( 'AUTH_KEY',         '5 h *m5unl pOQNkXQ]Q7-.oPr.V_)fa#Qhhe}j{*fG1cRTFU0_;9#FR$^3V$?N0' );
define( 'SECURE_AUTH_KEY',  'Ws>mp2?ChtX|4o^lvQKsLH[eDULtk6D_i3WYr?`_rXr%48ay-:=urfH%Ia{0E5[o' );
define( 'LOGGED_IN_KEY',    '-s!Nb#s7aZggE!*/%spsJ$l^e@?ateAgo>|Lb#I4(DT^^#i9]]T&dpvTb^Tr?-|l' );
define( 'NONCE_KEY',        '=wRC4Io_|!iI]4XG.j>0b>M*!7_Z+RqJwz}+kVUFPV,Wxp1wi_O:Ow2G=`$Kmk>z' );
define( 'AUTH_SALT',        '`*Ubi4)>c@w]U#%,t#TG/HOFN_Ic%0sv+enR@S3d/nUYdN$l}Nt8yl?q}FU=Reg*' );
define( 'SECURE_AUTH_SALT', 'hxrwWul xPbsD5qfkaN`!D-^zX$H{<Ur/i(x`_WHC7]=>*Fn47qghGjYl@,<;Uy=' );
define( 'LOGGED_IN_SALT',   '$Tu(=8/]{xg[CuyjWuy|)rgQp6T]@ x_iV(#q8RDWAV29N^{x`6+(^|71p%tCOBU' );
define( 'NONCE_SALT',       'wM+3NTM]+&!wFGv9xq~.XZ#zM5ncW$jIW{Bxyp{3@BN8Q2ADhfnOIEG!O:h8+W)D' );

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
