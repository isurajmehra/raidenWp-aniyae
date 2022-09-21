<?php

define('KIRA_DIR', get_stylesheet_directory() . '/core');
define('KIRA_URI', get_stylesheet_directory_uri());
define('KIRA_JS', KIRA_URI . '/js');
define('KIRA_CSS', KIRA_URI . '/css');
define('KIRA_VER', wp_get_theme()->get('Version'));

require_once KIRA_DIR . '/kiranime-init.php';

// load kiranime all required code
new Kiranime_Init;