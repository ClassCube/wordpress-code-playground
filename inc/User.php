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

    add_shortcode( 'cc_notexturize', function($atts, $content) {
      return $content;
    } );
    add_filter( 'no_texturize_shortcodes', function($shortcodes) {
      $shortcodes[] = 'cc_notexturize';
      return $shortcodes;
    } );

    add_action( 'wp_ajax_code_playground', [ self::class, 'submit_code' ] );
    add_action( 'wp_ajax_nopriv_code_playground', [ self::class, 'submit_code' ] );
  }

  public static function register_scripts() {
    wp_register_script( 'classcube-ace', 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.6/ace.js', [ 'jquery' ], null );
    wp_register_script( 'classcube-playground', plugins_url( 'js/dist/code-playground.min.js', __DIR__ ), [ 'jquery' ], filemtime( plugin_dir_path( __DIR__ ) . 'js/dist/code-playground.min.js' ) );

    wp_register_style( 'classcube-playground', plugins_url( 'css/playground.css', __DIR__ ), [], filemtime( plugin_dir_path( __DIR__ ) . 'css/playground.css' ) );
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
    wp_localize_script( 'classcube-playground', 'classcube_playground', [ 'ajaxurl' => admin_url( 'admin-ajax.php' ) ] );

    if ( Settings::get_option( 'load_ace', true ) ) {
      wp_enqueue_script( 'classcube-ace' );
    }
    if ( Settings::get_option( 'load_css', true ) ) {
      wp_enqueue_style( 'classcube-playground' );
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
    echo '[cc_notexturize]';
    include($template_path);
    echo '[/cc_notexturize]';
    return apply_filters( 'classcube_playground_editor', ob_get_clean() );
  }

  /**
   * Ajax backend to submit code to ClassCube API and return the results. 
   */
  public static function submit_code() {
    $data = [
        'code' => $_POST[ 'code' ],
        'language' => $_POST[ 'language' ]
    ];
    $url = 'https://app.classcube.com/api/run/';
    $request_body = json_encode( $data );
    $timestamp = time();

    $hash = self::generate_hash( $request_body, $timestamp );
    $headers = [
        'User-Agent' => 'WordPress/' . get_bloginfo( 'version' ) . '; ' . get_home_url(),
        'X-CC-KEY' => Settings::get_option( 'api_key', '' ),
        'X-CC-TIMESTAMP' => $timestamp,
        'X-CC-HASH' => $hash,
        'Content-Type' => 'application/json'
    ];

    $response = wp_remote_post( $url, [
        'headers' => $headers,
        'body' => $request_body
            ] );
    header( 'Content-type: application/json' );
    die( $response[ 'body' ] );
  }

  private static function generate_hash( $body, $timestamp ) {
    $content_no_ws = preg_replace( '/\s+/', '', $body );
    $hash_string = $content_no_ws . Settings::get_option( 'api_key', '' ) . $timestamp;
    return hash_hmac( 'sha256', $hash_string, Settings::get_option( 'api_secret', '' ) );
  }

}
