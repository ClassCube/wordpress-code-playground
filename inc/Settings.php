<?php

namespace ClassCube\WordPress\Playground;

Settings::init();

class Settings {

  private static $options = [];
  private static $defaults = [
      'api_key' => '',
      'api_secret' => '',
      'load_ace' => true,
      'load_css' => true,
      'font_size' => 18,
      'ace_theme' => 'github'
  ];

  public static function init() {
    self::load_settings();
  }

  /**
   * Loads the settings from database options table
   */
  public static function load_settings() {
    $opts = json_decode( get_option( 'code_playground' ), true );
    if ( empty( $opts ) ) {
      $opts = [];
    }
    self::$options = array_merge( self::$defaults, $opts );
  }

  /**
   * Update the settings back into the database
   */
  public static function update_settings() {
    $json = json_encode( self::$options );
    update_option( 'code_playground', $json );
  }

  /**
   * Pull an option 
   * 
   * @param string $key
   * @param mixed $default
   * @param boolean $reload If true, load from the database first. Otherwise
   *                        it'll pull from self::$options
   */
  public static function get_option( $key, $default = false, $reload = false ) {
    if ( $reload ) {
      self::load_settings();
    }
    return isset( self::$options[ $key ] ) ? self::$options[ $key ] : $default;
  }

  /**
   * Save an option to self::$options and optionally, by default, saves it
   * back to the database as well. 
   * 
   * @param string $key
   * @param mixed $value
   * @param boolean $defer
   */
  public static function set_option( $key, $value, $defer = false ) {
    self::$options[ $key ] = $value;
    if ( ! $defer ) {
      self::update_settings();
    }
  }

}
