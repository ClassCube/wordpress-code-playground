
(function () {
  var __ = wp.i18n.__;
  var createElement = wp.element.createElement; 
  var registerBlockType = wp.blocks.registerBlockType; 
  
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
            icon: 'edit', 
            category: 'embed', 
            attributes: {
              content: {
                type: 'string',
                default: 'Editable block content...',
              },
            },

            // Defines the block within the editor.
            edit: function (props) {
            },

            // Defines the saved block.
            save: function (props) {
            },
          }
  );
})();