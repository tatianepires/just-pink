<?php
/*
 * Frontend scripts
 *
 * Enqueue theme's CSS
 */

function just_pink_frontend() {
  // Parent theme's CSS
  wp_enqueue_style('twentytwelve', get_template_directory_uri() . '/style.css' );

  // Google Fonts
  wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Indie+Flower|Open+sans');
 
  // Theme's CSS
  wp_enqueue_style('tps', get_stylesheet_directory_uri() . '/style.css', array('twentytwelve'));
}
add_action( 'wp_enqueue_scripts', 'just_pink_frontend' );
