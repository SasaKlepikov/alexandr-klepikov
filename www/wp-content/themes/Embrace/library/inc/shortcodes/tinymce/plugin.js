tinymce.PluginManager.add('reactor_button', function(ed, url) {
    ed.addCommand("reactorPopup", function ( a, params )
    {
        var popup = 'shortcode-generator';

        if(typeof params != 'undefined' && params.identifier) {
            popup = params.identifier;
        }
        
        jQuery('#TB_window').hide();

        // load thickbox
        tb_show("Reactor Shortcodes", ajaxurl + "?action=reactor_shortcodes_popup&popup=" + popup + "&width=" + 800);
    });

    // Add a button that opens a window
    ed.addButton('reactor_button', {
        text: '',
        icon: true,
        image: ReactorShortcodes.plugin_folder + '/tinymce/images/icon.png',
        cmd: 'reactorPopup'
    });
});