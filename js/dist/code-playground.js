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
jQuery(document).ready(function() { classcubePlayground.init(); }); 

var classcubePlayground = {
  init: function() {
    jQuery.each(jQuery('.codeplayground-wrapper [data-editor]'), function(idx, el) {
      var ed = ace.edit(el, {
        minLines: 5,
        maxLines: 100,
        fontSize: jQuery(el).data('fontsize'),
        mode: 'ace/mode/' + jQuery(el).data('language'),
        theme: 'ace/theme/' + jQuery(el).data('theme')
      }); 
    });
    
    jQuery.each(jQuery('.codeplayground-wrapper button[data-button="reset"]'), function(idx, el) {
      jQuery(el).click(function(evt) {
        var starter = jQuery(el).data('starter');
        ace.edit(jQuery(el).parents('.codeplayground-wrapper').find('.codeplayground-editor')[0]).session.setValue(starter); 
      });
    });
    
    jQuery.each(jQuery('.codeplayground-wrapper button[data-button="submit"]'), function(idx, el) {
      jQuery(el).click(function(evt) {
        var ed = jQuery(el).parents('.codeplayground-wrapper').find('.codeplayground-editor');
        var lang = ed.data('language');
        var code = ace.edit(ed[0]).session.getValue();
        console.info(lang);
        console.info(code); 
      });
    });
  }
}
