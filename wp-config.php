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
define('DB_NAME', 'ieeetvte_new_ieeelk');

/** MySQL database username */
define('DB_USER', 'ieeetvte_new_ieee_user');

/** MySQL database password */
define('DB_PASSWORD', '(RQ;WDp#},_$E)4*%}');

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
define('AUTH_KEY',         ',V/o@#OsiczRm$WWK~w%ZErHUtr^w9<i,9$2Km!kzz@}HED,F4/&b9Bk9RA8.+5A');
define('SECURE_AUTH_KEY',  'v*|n)-)[|*G?^M_.KEkY=,G$^-$&Ll2:<Ek1s5|FM=(r5g8N.g.S_fK#*l[;HvNp');
define('LOGGED_IN_KEY',    '3+yh`5u ,E8lMS/t=:_ {g{C5:S7JKeAXXN]?w6[Uds0~mE9V U[<t.ke=y/p3wp');
define('NONCE_KEY',        '}h@naFY(3Qp^C&E%E1HKy6/&g!<oFdzlwBBZRen!O&I_QJy[}a5bM%QN=GO7wd8s');
define('AUTH_SALT',        '` C`R<)VQW M*O6+ik@;7&U_45h+.HU3{*{/s?q7r_y>H(!dwU^xLcNDn #~osWR');
define('SECURE_AUTH_SALT', '&W)I!|ec/YY<,P8fmy2%&8USotU*Y%CI3fB$BPtkXL96QO5?D?a`Xa]vWX(tz{|N');
define('LOGGED_IN_SALT',   'R~}c2UeSUi` }5xdI|Vn0S5CwF,7s)aDT|5PQ8;CZxs]!bqgk9zp*ht7FYKd8yL/');
define('NONCE_SALT',       'N<5K=e5=2B#=oGG8(XBF9Yz.k!%EX}li`B(xQ.X)248> A;?5DPuCT3R^HS1mGJj');

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
