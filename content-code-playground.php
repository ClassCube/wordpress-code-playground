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

/**
 * This is the template file used for any code playgrounds you enter 
 * into your site. If you'd like to customize the layout, copy this
 * file to the root of your theme folder and that copy will be used
 * instead of this one. You don't want to edit this file because your
 * changes might be overwritten by a future update to this plugin.   
 */
global $post;
use \ClassCube\WordPress\Playground\Settings; 

$props[ 'id' ] = uniqid( 'editor-' );
?>
<div class="codeplayground-wrapper" id="<?php echo($props[ 'id' ]); ?>" style="">  
  <div class="codeplayground-editor" data-editor data-id="<?php echo $props[ 'id' ]; ?>" data-fontsize="<?php echo esc_attr(Settings::get_option('font_size', 18)); ?>" data-theme="<?php echo esc_attr(Settings::get_option('ace_theme')) ?>" data-language="<?php echo $props[ 'language' ]; ?>"><?php echo $props[ 'code' ]; ?></div>
  <div class="codeplayground-console">&gt; </div>
  <div class="buttons">
    <button class="play" data-button="submit"><?php _e('Submit', 'code-playground'); ?></button>
    <button class="reset" data-button="reset" data-id="<?php echo esc_attr($props['id']); ?>" data-starter="<?php echo esc_attr( $props[ 'code' ] ); ?>"><?php _e('Reset', 'code-playground'); ?></button>
  </div>
</div>