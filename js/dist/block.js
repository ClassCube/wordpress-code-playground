
(function () {
  var __ = wp.i18n.__;
  var createElement = wp.element.createElement;
  var registerBlockType = wp.blocks.registerBlockType;
  var InspectorControls = wp.blocks.InspectorControls;
  var ToggleControl = wp.blocks.ToggleControl;
  var BlockControls = wp.blocks.BlockControls;
//  var PanelBody = wp.components.PanelBody; 
  console.info(wp);
//  console.info('debug');
//  console.info(wp);
//  console.info(wp.editor); 
//  console.info(wp.editor.InspectorControls); 
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
            attributes: {
              language: {
                type: 'string',
                default: 'java'
              },
              style: {
                type: 'string',
                default: 'github'
              },
              content: {
                type: 'string',
                default: 'Editable block content...',
              },
            },

            // Defines the block within the editor.
            edit: function (props) {
              var el = wp.element.createElement;
              return el(
                      wp.element.Fragment,
                      null,
                      el(
                              wp.editor.InspectorControls,
                              null,
                              el(wp.components.PanelBody, {
                                title: __('Editor Options', 'code-playground'),
                                initialOpen: true
                              },
                                      el(
                                              wp.components.SelectControl, {
                                                label: __('Language', 'code-playground'),
                                                value: 'java',
                                                options: [
                                                  {label: 'Java', value: 'java'},
                                                  {label: 'Python', value: 'python'}
                                                ]
                                              })
                                      )),
                      el('div',
                              {},
                              el('p', {}, 'This will be the editor')));

            },

            // Defines the saved block.
            save: function (props) {
            },
          }
  );
})();