<?php
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-stylesheet', get_template_directory_uri() . '/style.css' );
//	wp_enqueue_script( 'avada' );

}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );
}
add_action( 'after_setup_theme', 'avada_lang_setup' );

/* To work with TypeKit
function theme_typekit() {
      wp_enqueue_script( 'theme_typekit', '//use.typekit.net/eoe0gac.js', '', false);
  }
  add_action( 'wp_enqueue_scripts', 'theme_typekit' );

  function theme_typekit_inline() {
    if ( wp_script_is( 'theme_typekit', 'done' ) ) { ?>
      <script>try{Typekit.load();}catch(e){}</script>
    <?php }
  }
  add_action( 'wp_head', 'theme_typekit_inline' );*/


include_once (get_stylesheet_directory() . '/wristband/class-wristband.php');


