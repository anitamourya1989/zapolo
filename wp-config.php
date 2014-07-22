<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'zapz');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'yi$123');

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
define('AUTH_KEY',         'B>j>X4xC9l0D7C,I#;VZ*`dlST/N|_QXebB}t0.47@ubQZm@bbTM3<^n,Y-X1V+7');
define('SECURE_AUTH_KEY',  '/9Ft[;5ZzPV1@HG?UAZuGnl<> wZ]d/k%@$la)f~|t?<vppc:$Tma%$?+/?YGYHO');
define('LOGGED_IN_KEY',    '#;T+jqQ]R^*sn),6Eu6~IOCWhLzF42CrpOih;kzMCb~xDSC]JigCU{AT9$:lpQt,');
define('NONCE_KEY',        ' Rzs_%]FG=3Mp1V~PD~wFFdbN~oh1{o2(ppqaGSNjISS!ZTh1OVHQn!XWE}%XzAI');
define('AUTH_SALT',        'k38RW N ]D768;Fz6tgx2+%Ja}6)k+&j&Fsgl?L^O(Dj2yzaa`1ys9l%l}/;Xnq]');
define('SECURE_AUTH_SALT', '|%2]O_WWZA$*e:_I}*!f/[Fjp8h?:6#6FG$+M{Y)YYB+/64Xd;R.ymGW]#C 9]LI');
define('LOGGED_IN_SALT',   'Q3BoP)kQD:jg< ]07IC2e$ke9Y;tS+M GwH^dRESQCu)kVO=GycSLldLX|wVy#rl');
define('NONCE_SALT',       '0]AQ?cD:j gHl7l:NsFCH,-yzjy>ASo<t84/*;-3Kd~vP]f{{~J-!wD&r%`86d&[');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
