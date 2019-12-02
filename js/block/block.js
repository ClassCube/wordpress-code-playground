
(function () {
  var __ = wp.i18n.__;
  var createElement = wp.element.createElement;
  var registerBlockType = wp.blocks.registerBlockType;
  var InspectorControls = wp.blocks.InspectorControls;
  var ToggleControl = wp.blocks.ToggleControl;
  var BlockControls = wp.blocks.BlockControls;
  /**
   * Register block
   *
   * @param  {string}   name     Block name.
   * @param  {Object}   settings Block settings.
   * @return {?WPBlock}          Block itself, if registered successfully,
   *                             otherwise "undefined".
   */
  registerBlockType(
          'classcube/code-playground',
          {
            title: __('Code Playground', 'code-playground'),
            icon: 'media-code',
            category: 'common',
            description: __('Insert a code sandbox for your visitors to play around in', 'code-playground'),
            attributes: {
              code: {default: ''},
              language: {default: 'java'},
              extraStyles: {default: ''}
            },
            supports: {
              html: false,
              reusable: false
            },
            // Defines the block within the editor.
            edit: function (props) {
              var createElement = wp.element.createElement; 
              interval = setInterval(function () {
                var el = jQuery('div[data-block="' + props.clientId + '"]');
                if (jQuery(el).length) {
                  if (!el.data('editor-loaded')) {
                    ed = ace.edit(jQuery('div[data-editor="' + props.clientId + '"]')[0], {
                      minLines: 5,
                      maxLines: Infinity,
                      fontSize: classcube_code_playground.font_size + 'px',
                      theme: 'ace/theme/' + classcube_code_playground.ace_theme
                    });
                    ed.session.setMode('ace/mode/' + props.attributes.language); 
                    ed.setValue(jQuery('textarea[data-parent="' + props.clientId + '"]').val(), -1);
                    ed.on('change', function(evt) {
                      props.setAttributes({code: ed.getValue()});                       
                    });
                    jQuery('textarea[data-parent="' + props.clientId + '"]').hide();
                    el.data('editor-loaded', true);
                  }
                  clearInterval(interval);
                }
              }, 250);
              return createElement(
                      wp.element.Fragment,
                      null,
                      createElement(
                              wp.editor.InspectorControls,
                              null,
                              createElement(wp.components.PanelBody, {
                                title: __('Editor Options', 'code-playground'),
                                initialOpen: true
                              },
                                      createElement(
                                              wp.components.SelectControl, {
                                                label: __('Language', 'code-playground'),
                                                value: props.attributes.language,
                                                options: [
                                                  {label: 'Java', value: 'java'},
                                                  {label: 'Python', value: 'python'}
                                                ],
                                                onChange: function (val) {
                                                  props.setAttributes({language: val});
                                                  ace.edit(jQuery('div[data-editor="' + props.clientId + '"]')[0]).session.setMode('ace/mode/' + val); 
                                                }
                                              })
                                      ),
                              createElement(wp.components.PanelBody, {
                                title: __('Additional Settings', 'code-playground'),
                                initialOpen: false
                              },
                                      createElement(wp.components.TextControl, {
                                        label: 'CSS Style',
                                        value: props.attributes.extraStyles,
                                        onChange: function (val) {
                                          props.setAttributes({extraStyles: val});
                                        }
                                      }))),
                      createElement(wp.components.TextareaControl, {
                        value: props.attributes.code,
                        style: {
                          display: 'none'
                        },
                        onChange: function (val) {
                          props.setAttributes({code: val});
                        },
                        'data-parent': props.clientId
                      }),
                      createElement('div', {
                        'data-parent': props.clientId,
                        style: {
                          width: '100%',
                          height: '100%',
                          position: 'relative'
                        }

                      }, createElement('div', {
                        'data-editor': props.clientId,
                        style: {
                          width: '100%',
                          position: 'relative'
                        }
                      }, ''))
                      );

            },

            // Defines the saved block.
            save: function (props) {
              return null;
            }
          }
  );
})();