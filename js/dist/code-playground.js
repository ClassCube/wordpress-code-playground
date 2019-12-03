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
jQuery(document).ready(function () {
  classcubePlayground.init();
});

var classcubePlayground = {
  init: function () {
    jQuery.each(jQuery('.codeplayground-wrapper [data-editor]'), function (idx, el) {
      var ed = ace.edit(el, {
        minLines: 5,
        maxLines: 100,
        fontSize: jQuery(el).data('fontsize'),
        mode: 'ace/mode/' + jQuery(el).data('language'),
        theme: 'ace/theme/' + jQuery(el).data('theme')
      });
    });

    jQuery.each(jQuery('.codeplayground-wrapper button[data-button="reset"]'), function (idx, el) {
      jQuery(el).click(function (evt) {
        var starter = jQuery(el).data('starter');
        ace.edit(jQuery(el).parents('.codeplayground-wrapper').find('.codeplayground-editor')[0]).session.setValue(starter);
      });
    });

    jQuery.each(jQuery('.codeplayground-wrapper button[data-button="submit"]'), function (idx, el) {
      jQuery(el).click(function (evt) {
        var ed = jQuery(el).parents('.codeplayground-wrapper').find('.codeplayground-editor');
        var wrapper = jQuery(el).parents('.codeplayground-wrapper');
        var lang = ed.data('language');
        var code = ace.edit(ed[0]).session.getValue();

        jQuery.ajax(classcube_playground.ajaxurl, {
          method: 'POST',
          data: {
            action: 'code_playground',
            language: lang,
            code: btoa(code)
          },
          beforeSend: function (xhr, settings) {
            var output = jQuery(wrapper).find('.codeplayground-console');
            jQuery(output).empty();
            jQuery(wrapper).find('button').attr('disabled', true);
            jQuery(wrapper).find('.codeplayground-console').append('<div class="cursor blinking" data-running="running">&gt; Running</div>');
          },
          complete: function (xhr, status) {
            jQuery(wrapper).find('button').attr('disabled', false);
            jQuery(wrapper).find('.codeplayground-console [data-running="running"]').remove();
          },
          error: function (xhr, status, error) {
            console.info(error);
            console.info(xhr); 
            var output = jQuery(wrapper).find('.codeplayground-console');
            jQuery(output).append('<div class="error">' + error + '</div><div class="cursor">&gt;</div>');
          },
          success: function (data, status, xhr) { console.info(data); 
            var output = jQuery(wrapper).find('.codeplayground-console');
            if (data.error) {
              jQuery(output).append('<div class="error">' + data.error + '</div>');
            } else if (data.stderr) {
              jQuery(output).append('<div class="stderr">' + data.stderr + '</div>');
            } else {
              jQuery(output).append('<div class="stdout">' + data.stdout + '</div>');
            }
            jQuery(output).append('<div class="cursor">&gt;</div>');
          }
        });
      });
    });
  }
}
