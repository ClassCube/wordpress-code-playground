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
    wp_register_script( 'classcube-ace', 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.6/ace.js', ['jquery'], null );
  }

  public static function enqueue_scripts() {
    if ( Settings::get_option( 'load_ace', true ) ) {
      wp_enqueue_script( 'classcube-ace' );
    }
  }

  /**
   * Render the HTML for an editor
   * 
   * @param mixed $props  Settings for this block 
   * @return string
   */
  public static function render_block( $props ) {
    return 'Hello, this is the editing block...';
  }

}
