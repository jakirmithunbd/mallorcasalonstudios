<?php /*

  This file is part of a child theme called Surprise Endodontics.
  Functions in this file will be loaded before the parent theme's functions.
  For more information, please read
  https://developer.wordpress.org/themes/advanced-topics/child-themes/

*/

// this code loads the parent's stylesheet (leave it in place unless you know what you're doing)


/*  Add your own functions below this line.
    ======================================== */

define('THEME_INC_DIR', dirname(__FILE__) . '/inc/');


// Includes the general functions file for the current theme.
require_once(THEME_INC_DIR . 'child-theme-enqueue.php');
require_once(THEME_INC_DIR . 'mallorca-ajax.php');
require_once(THEME_INC_DIR . 'mallorca-shortcodes.php');
require_once(THEME_INC_DIR . 'cpt.php');
require_once(THEME_INC_DIR . 'breadcrumb.php');

function mallorca_mime_types($mimes)
{
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'mallorca_mime_types');