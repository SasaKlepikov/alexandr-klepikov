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
define('DB_NAME', '');

/** MySQL database username */
define('DB_USER', '');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', '');

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
define('AUTH_KEY',         'Uw;ZhO;|E|[Oep*32{?O~(nM.*WYv|R(Ial@bF{4wVC{~Ya,#B]]r+rG-7B})Afy');
define('SECURE_AUTH_KEY',  'Y^Q={udxuHC1}NFfS=RF7(%aEPfu@g-[^v|*Vw.V0RD!=?$!pn+W>QU-+C#0K+>V');
define('LOGGED_IN_KEY',    ';l-G{c]}-e-0?WubNEsRip-qsR!+?w1(pet@n(NRX(7K?GZmyP;+.Lv#=9-E3|Qh');
define('NONCE_KEY',        'wmqQLzh#f0|+>eEv*q:*JE-y+4lymA64l.gXh,TX#I/wlO= Yh)86%N8@f(pkB3!');
define('AUTH_SALT',        'cO+|V&JxE`H<Kr19rov>w^)eS5Q*zL&hYN2&H(#hiQsh2eN=76TD+=iwR7J j:aX');
define('SECURE_AUTH_SALT', 'HoJG5GE/oN)5G} x-heXPj.$Wa}Qn@7oE4RPOGIPK#d<[qK+nSPA(. IAWSMOd6Y');
define('LOGGED_IN_SALT',   'OS24jFZokCK7Z#lvg~-2| g|crB9:$u~D,UBMx4fzBX 6*|fpd?KPU:| xl{#{G{');
define('NONCE_SALT',       '>D4gwWUS-(?+*QSLi8kr7pwV&:+&]T|%Yx,b}+B*K9-wsTg1 Y~DU-MD&(SpDV)-');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'akwp_';

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
