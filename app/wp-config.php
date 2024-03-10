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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'notr' );

/** Database username */
define( 'DB_USER', 'wordpress' );

/** Database password */
define( 'DB_PASSWORD', 'wordpress' );

/** Database hostname */
define( 'DB_HOST', 'db' );

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
define( 'AUTH_KEY',         ';/=09$|^V$$P=DwRE:q7=V9t} `k/NsUGn*Iyo2[uef&L,Ae{m)+kie1)d^`Lv<s' );
define( 'SECURE_AUTH_KEY',  '|mt- HVAe1/x3=F)RpG0:Vx+@BXKt|!9MD$n-`_.Z9-~uw)j$<~]S^zD&:n?]6_M' );
define( 'LOGGED_IN_KEY',    '?1<io 1K,1X8d9/zK|4F{BFrBap+SgcX{Q`2,7%G-vht mp6Ju15EI6gDe1@Si$/' );
define( 'NONCE_KEY',        '9J1T@9B&a-;^]wx:5yxk%CGKgRP^9*zZ+oTrPq/IKd~6Dn8ukj2FYw>Af%s+_5&{' );
define( 'AUTH_SALT',        'd|N6#M[= 8va^~outTur.Q!&xYpyRh3=0!oGPriMT4N[!e5s,F383J!{/A-*CV}g' );
define( 'SECURE_AUTH_SALT', 'JV8s%#P<Vjf;ri,f`ORd>%hu[daaULl{~IQ:{F5Mmq/duGW-lX ;:@J!px;xbHAN' );
define( 'LOGGED_IN_SALT',   ' lyvgFbygK& Bd`;%-O0&bM#EItc<=Cv?DA-ap-}Bc]EK:;]~W+D89bt^({{8V@4' );
define( 'NONCE_SALT',       'e[VH+#^a}|d^A 8v+w|T]cvq %g}M42C)o8J*uLn7x4]Y]IM<)>)HQ7AT!@:zD|`' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );
define( 'WP_SANDBOX_SCRAPING', TRUE);


/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
