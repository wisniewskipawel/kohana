<?php

define('DB_NAME', '1245_wp_2');
define('DB_USER', '1245_wp_2');
define('DB_PASSWORD', 'yEc8030VFDFchg');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');
define('AUTH_KEY',         'kB:`+P>`.T(IVa6hZ:B>iF5SYX#.}7WB|0BS(^+d*#=iD*c|-7[hB7M&DnYtC`k]');
define('SECURE_AUTH_KEY',  'UFL:k`2wS Nb!}m&<?n|i{PqM{]Q8s[-xo^kUkl`oMl8ANjl.NUx<Y~pwB$FE<4y');
define('LOGGED_IN_KEY',    '|{k}Z<(CZjpn*Z5*R0W/o[JB3GciRcCwn#!U.9Krky1[P;F/jAVw8U.w{+F|cKSE');
define('NONCE_KEY',        '.1fD*U.;$TZKRrX~o)86L*,Bix!Si!|$J6}1,[VOz8*c4_.@wX?>Xl]Ed;zQ?Mv+');
define('AUTH_SALT',        'f ]9_rph;rwn+*u*::OF+Vl1`@QrJx-|]FN>N`P-,1!i0[ek84#Vu&f(~Bd#F7wZ');
define('SECURE_AUTH_SALT', 'vUk,.pAan~qaQ%q:10vJ$aU-C?ZUgoed7,iiiRxYjen--z]]>QK*Mj-5CuT+dPUi');
define('LOGGED_IN_SALT',   'tLBGP{wz&<Z3X!~+xO=C7l=wWZi;N%+JP++/?{wK/2R<3Hu>~p_O-w`en|HFE1d,');
define('NONCE_SALT',       'QckR~9(||PQr|)Llw0[n-qje$V4}k}F9,rNyj7w_!gnNYnC4pU+oLnw0G/6H[ 74');

$table_prefix  = 'wp_';
define('WP_DEBUG', false);

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

require_once(ABSPATH . 'wp-settings.php');