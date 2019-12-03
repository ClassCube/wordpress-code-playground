<?php

/**
 * Plugin Name:       Code Playground
 * Plugin URI:        https://classcube.com
 * Description:       Run code on your WordPress site using the ClassCube API
 * Version:           0.1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Ryan Nutt
 * Author URI:        https://www.nutt.net
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       code-playground
 */
$dir = plugin_dir_path( __FILE__ );
require($dir . 'inc/Settings.php');
require($dir . 'inc/User.php');
require($dir . 'inc/Admin.php');

if (!class_exists('\ClassCube\WordPress\Playground\Smashing_Updater')) {
  require($dir . 'inc/Smashing_Updater.php'); 
}
$updater = new \ClassCube\WordPress\Playground\Smashing_Updater( __FILE__ );
$updater->set_username( 'classcube' );
$updater->set_repository( 'wordpress-code-playground' );
$updater->initialize();