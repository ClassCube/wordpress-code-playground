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
  Settings::set_option( 'ace_theme', $_POST[ 'code_playground' ][ 'ace_theme' ], true );

  $font_size = (int) $_POST[ 'code_playground' ][ 'font_size' ];
  if ( $font_size < 6 )
    $font_size = 6;
  if ( $font_size > 48 )
    $font_size = 48;
  Settings::set_option( 'font_size', $font_size, true );

  Settings::update_settings();
  $updated = true;
}

$ace_light = [
    'chrome' => 'Chrome',
    'clouds' => 'Clouds',
    'crimson_editor' => 'Crimson Editor',
    'dawn' => 'Dawn',
    'dreamweaver' => 'Dreamweaver',
    'eclipse' => 'Eclipse',
    'github' => 'GitHub',
    'iplastic' => 'IPlastic',
    'katzenmilch' => 'KatzenMilch',
    'kuroir' => 'Kuroir',
    'solarized_light' => 'Solarized Light',
    'sqlserver' => 'SQL Server',
    'textmate' => 'TextMate',
    'tomorrow' => 'Tomorrow',
    'xcode' => 'XCode'
];
$ace_dark = [
    'ambiance' => 'Ambiance',
    'chaos' => 'Chaos',
    'clouds_midnight' => 'Clouds Midnight',
    'cobalt' => 'Cobalt',
    'dracula' => 'Dracula',
    'gob' => 'Greeon on Black',
    'gruvbox' => 'Gruvbox',
    'idle_fingers' => 'idle Fingers',
    'kr_theme' => 'krTheme',
    'merbivore' => 'Merbivore',
    'merbivore_soft' => 'Merbivore Soft',
    'mono_industrial' => 'Mono Industrial',
    'monokai' => 'Monokai',
    'pastel_on_dark' => 'Pastel on Dark',
    'solarized_dark' => 'Solarized Dark',
    'terminal' => 'Terminal',
    'tomorrow_night' => 'Tomorrow Night',
    'tomorrow_night_blue' => 'Tomorrow Night Blue',
    'tomorrow_night_bright' => 'Tomorrow Night Bright',
    'tomorrow_night_eighties' => 'Tomorrow Night 80s',
    'twilight' => 'Twilight',
    'vibrant_ink' => 'Vibrant Ink'
];

$ace_themes = array_merge( $ace_light, $ace_dark );
?>
<div class="wrap">
  <h1><?php _e( 'Code Playground Settings', 'code-playground' ); ?></h1>
  <?php if ( $updated ) { ?>
    <div class="notice notice-success is-dismissible"> 
      <p><strong><?php _e( 'Settings Updated', 'code-playground' ); ?></strong></p>
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
      <tr>
        <th><?php _e( 'Editor Theme', 'code-playground' ); ?></th>
        <td>
          <select name="code_playground[ace_theme]">
            <optgroup label="<?php _e( 'Light Themes', 'code-playground' ); ?>">
              <?php
              foreach ( $ace_light as $k => $v ) {
                echo '<option value="' . $k . '" ' . selected( $k, Settings::get_option( 'ace_theme', 'github' ), false ) . '>' . $v . '</option>';
              }
              ?>
            </optgroup>
            <optgroup label="<?php _e( 'Dark Themes', 'code-playground' ); ?>">
              <?php
              foreach ( $ace_dark as $k => $v ) {
                echo '<option value="' . $k . '" ' . selected( $k, Settings::get_option( 'ace_theme', 'github' ), false ) . '>' . $v . '</option>';
              }
              ?>
            </optgroup>
          </select>
        </td>
      </tr>
      <tr>
        <th><?php _e( 'Editor Font Size', 'code-playground' ); ?></th>
        <td>
          <input type="number" max=48 min=6 name="code_playground[font_size]" value="<?php echo esc_attr( Settings::get_option( 'font_size', 18 ) ); ?>">
        </td>
      </tr>
    </table>
    <?php submit_button( __( 'Update Settings', 'code-playground' ) ); ?>
  </form>
</div>

