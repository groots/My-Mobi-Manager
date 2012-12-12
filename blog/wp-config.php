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

define('DB_NAME', 'squish7_miMoby');



/** MySQL database username */

define('DB_USER', 'squish7_expert');



/** MySQL database password */

define('DB_PASSWORD', 'XmjujdK*I;6%');



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

define('AUTH_KEY',         'LQZ[D#jr-iaKp?=H 8LQ8>[=6O#h93)]|C:P/duSCt[tk{, rwti+cU.RO=80BQv');

define('SECURE_AUTH_KEY',  ':+TOG.2$|+=Yx%`p:+*uqM,F98C:+HXg>&E-2vh@r~eJu?},-%9a*-@&hhld-H=s');

define('LOGGED_IN_KEY',    '~~rX:^)jhfKV=ktO9Fce]t6PKm!3-|jLD}:6TmNYh:7Qi@C,*Qwgh MS9V:qQ-5m');

define('NONCE_KEY',        'X_^b26YhH};$s+4C<y6M7N|n3r<|iZB>5NT]GMc3]UzS+.}&$;WW5k,}$7`vu^>^');

define('AUTH_SALT',        'kvFUc8@C$~0cqje$3!FT>]XQ%vX`0^Uj0d4Y}tIb6d-oy{#-!ga|iS9mm)UV.R^T');

define('SECURE_AUTH_SALT', 'Hj;UVBByh-30~EeyI-;/juY<cY&UI#j:HbI2+tq4JKvHP[r21Werjf-4-Q$cQ/sV');

define('LOGGED_IN_SALT',   'U:d<TOtYYbfqPjt^=Bp,UfY@?-fZQo9lxi.)YV.55_*%w]gYq*~/xH9,GI>+-HXc');

define('NONCE_SALT',       '&-kQ6}l4H#QS-6d?}6_OL$ET^{|qIe2O&OrH1!F|x/3oOA&_%6}gg5=oQs)C JRK');



/**#@-*/



/**

 * WordPress Database Table prefix.

 *

 * You can have multiple installations in one database if you give each a unique

 * prefix. Only numbers, letters, and underscores please!

 */

$table_prefix  = 'mobilemanager_';



/**

 * WordPress Localized Language, defaults to English.

 *

 * Change this to localize WordPress.  A corresponding MO file for the chosen

 * language must be installed to wp-content/languages. For example, install

 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German

 * language support.

 */

define ('WPLANG', '');



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

