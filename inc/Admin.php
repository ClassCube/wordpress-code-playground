<?php

namespace ClassCube\WordPress\Playground;

Admin::init();

class Admin {

  public static function init() {
    add_action( 'admin_menu', [ self::class, 'add_menus' ] );
    add_action( 'enqueue_block_assets', [ self::class, 'block_assets' ] );
  }

  public static function add_menus() {
    add_options_page( __( 'ClassCube Code Playground Settings', 'code-playground' ),
            __( 'Code Playground', 'code-playground' ),
            'manage_options',
            'code-playground.php',
            [ self::class, 'settings_menu' ] );
  }

  public static function settings_menu() {
    require(__DIR__ . '/layout/settings.php');
  }

  /**
   * Enqueue assets needed for the block editor 
   */
  public static function block_assets() {
    wp_enqueue_script(
            'classcube-code-playground-block',
            plugins_url( 'js/dist/block.min.js', __DIR__ ),
            [ 'wp-blocks', 'classcube-ace' ],
            filemtime( plugin_dir_path( __DIR__ ) . 'js/dist/block.min.js' )
    );
    wp_localize_script('classcube-code-playground-block', 'classcube_code_playground', [
        'font_size' => Settings::get_option('font_size', 18),
        'ace_theme' => Settings::get_option('ace_theme', 'github')
    ]);
    
  }
  
  public static function render_block() {
    return 'hi'; 
  }

}
