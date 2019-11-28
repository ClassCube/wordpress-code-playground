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
require($dir . 'inc/Admin.php');
