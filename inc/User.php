<?php

/*
 * Copyright (C) 2019 Aelora Web Services, LLC
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace ClassCube\WordPress\Playground;

User::init();

/**
 * Client side stuff for the plugin
 */
class User {

  public static function init() {
    register_block_type( 'classcube/code-playground', [
        'render_callback' => [ self::class, 'render_block' ]
    ] );

    add_action( 'wp_enqueue_scripts', [ self::class, 'enqueue_scripts' ] );
    add_action( 'init', [ self::class, 'register_scripts' ] );
  }

  public static function register_scripts() {
    wp_register_script( 'classcube-ace', 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.6/ace.js', [ 'jquery' ], null );
    wp_register_script( 'classcube-playground', plugins_url( 'js/dist/code-playground.min.js', __DIR__ ), [ 'jquery' ], filemtime( plugin_dir_path( __DIR__ ) . 'js/dist/code-playground.min.js' ) );
    
    wp_register_style('classcube-playground', plugins_url('css/playground.css', __DIR__), [], filemtime(plugin_dir_path(__DIR__) . 'css/playground.css'));
  }

  /**
   * Enqueue JavaScript or CSS needed client side
   * 
   * This looks at any posts currently in the query to see if there are any
   * using the code playground block, and if there are any then look at 
   * loading JS and CSS. 
   * 
   * Feels like there may be a better way to do this, but this is working
   * well enough for now. 
   * 
   * @global type $wp_query
   */
  public static function enqueue_scripts() {
    global $wp_query;
    $post_ids = wp_list_pluck( $wp_query->posts, 'ID' );

    $has_playground = false;
    foreach ( $post_ids as $id ) {
      if ( has_block( 'classcube/code-playground', $id ) ) {
        $has_playground = true;
        break;
      }
    }

    if ( ! $has_playground ) {
      /* Just bail, no playgrounds to deal with */
      return;
    }

    wp_enqueue_script( 'classcube-playground' );

    if ( Settings::get_option( 'load_ace', true ) ) {
      wp_enqueue_script( 'classcube-ace' );
    }
    if (Settings::get_option('load_css', true)) { 
      wp_enqueue_style('classcube-playground'); 
    }
  }

  /**
   * Render the HTML for an editor
   * 
   * @param mixed $props  Settings for this block 
   * @return string
   */
  public static function render_block( $props ) {
    $template_path = locate_template( 'content-code-playground.php' );
    if ( empty( $template_path ) ) {
      $template_path = dirname( __DIR__ ) . '/content-code-playground.php';
    }
    $props = shortcode_atts( [
        'language' => 'java',
        'code' => '',
        'extraStyles' => ''
            ], $props );
    ob_start();
    include($template_path);
    return ob_get_clean();
  }

}
