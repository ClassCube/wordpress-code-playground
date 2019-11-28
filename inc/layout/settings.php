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
$updated = false; 
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
  Settings::set_option( 'api_key', $_POST[ 'code_playground' ][ 'api_key' ], true );
  Settings::set_option( 'api_secret', $_POST[ 'code_playground' ][ 'api_secret' ], true );
  Settings::set_option( 'load_ace',  ! empty( $_POST[ 'code_playground' ][ 'load_ace' ] ), true );
  Settings::set_option( 'load_css',  ! empty( $_POST[ 'code_playground' ][ 'load_css' ] ), true );

  Settings::update_settings();
  $updated = true; 
}
?>
<div class="wrap">
  <h1><?php _e( 'Code Playground Settings', 'code-playground' ); ?></h1>
  <?php if ( $updated ) { ?>
    <div class="notice notice-success is-dismissible"> 
      <p><strong><?php _e('Settings Updated', 'code-playground'); ?></strong></p>
      <button type="button" class="notice-dismiss">
        <span class="screen-reader-text">Dismiss this notice.</span>
      </button>
    </div>
  <?php } ?>
  <form method="POST">
    <table class="form-table">
      <tr>
        <th><?php _e( 'ClassCube API Key', 'code-playground' ); ?></th>
        <td>
          <input type="text" class="regular-text" name="code_playground[api_key]" value="<?php echo esc_attr( Settings::get_option( 'api_key', '' ) ); ?>">
        </td>
      </tr>
      <tr>
        <th><?php _e( 'ClassCube API Secret', 'code-playground' ); ?></th>
        <td>
          <input type="text" class="regular-text" name="code_playground[api_secret]" value="<?php echo esc_attr( Settings::get_option( 'api_secret', '' ) ); ?>">
        </td>
      </tr>
      <tr>
        <th><?php _e( 'Load Ace Editor', 'code-playground' ); ?></th>
        <td>
          <input type="checkbox" name="code_playground[load_ace]" <?php checked( Settings::get_option( 'load_ace', true ), true ); ?>>
        </td>
      </tr>
      <tr>
        <th><?php _e( 'Load CSS', 'code-playground' ); ?></th>
        <td>
          <input type="checkbox" name="code_playground[load_css]" <?php checked( Settings::get_option( 'load_css', true ), true ); ?>>
        </td>
      </tr>
    </table>
    <?php submit_button( __( 'Update Settings', 'code-playground' ) ); ?>
  </form>
</div>

