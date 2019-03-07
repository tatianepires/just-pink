<?php
// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Stylesheets and Scripts
//   02. Use translation
//   03. Theme extras
// =============================================================================

// Stylesheets and Scripts
// =============================================================================

require_once get_stylesheet_directory() . '/inc/frontend-scripts.php';

// Use translation
// =============================================================================
function justpink_theme_setup(){
    load_theme_textdomain('justpink', get_stylesheet_directory().'/languages');
}
add_action('after_setup_theme', 'justpink_theme_setup');

// Theme extras
// =============================================================================
require_once get_stylesheet_directory() . '/inc/submenu-for-theme-options.php';
require_once get_stylesheet_directory() . '/inc/display-theme-extras.php';
