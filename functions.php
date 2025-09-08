<?php
/**
 * Educato Theme Functions
 * Modern WordPress theme with Tailwind CSS 4 and Alpine.js
 */

// Theme constants
if (!defined('EDUCATO_THEME_PATH')) define('EDUCATO_THEME_PATH', __DIR__);
if (!defined('EDUCATO_THEME_TEXTDOMAIN')) define('EDUCATO_THEME_TEXTDOMAIN', 'educato');
if (!defined('EDUCATO_THEME_VERSION')) define('EDUCATO_THEME_VERSION', '2.0.0');

// Load theme classes
require_once EDUCATO_THEME_PATH . '/lib/Theme.php';
require_once EDUCATO_THEME_PATH . '/lib/Navigation.php';
require_once EDUCATO_THEME_PATH . '/lib/Assets.php';
require_once EDUCATO_THEME_PATH . '/lib/Customizer.php';
require_once EDUCATO_THEME_PATH . '/lib/Walker_Nav_Menu.php';

// Initialize theme
function educato_init() {
    new \Educato\Theme();
    new \Educato\Navigation();
    new \Educato\Assets();
    new \Educato\Customizer();
}
add_action('after_setup_theme', 'educato_init');

// Theme localization
function educato_localization() {
    load_theme_textdomain('educato', get_template_directory() . '/lang');
}
add_action('after_setup_theme', 'educato_localization');

// Content width
if (!isset($content_width)) {
    $content_width = 1200;
}