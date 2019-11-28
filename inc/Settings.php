<?php

namespace ClassCube\WordPress\Playground;

Settings::init();

class Settings {

  private static $options = [];

  public static function init() {
    
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
    
  }

}
