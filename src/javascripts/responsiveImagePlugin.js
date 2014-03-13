/**
 * Responsive image tinymce plugin.
 * 
 * Lots of stuff borrowed from Wordpress's own Gallery plugin
 * 
 * Replaces [responsiveimage ... ] shortcodes with full-sized image in tinymce visual editor
 */
tinymce.PluginManager.add('responsiveImagePlugin', function(editor, url) {
    
    /**
     * Fired when content is added to the tinymce editor
     */
    editor.on('BeforeSetContent', function(event) {
        event.content = replaceResponsiveImageShortcodes(event.content);
    });

    /**
     * Fired after content from tinymce editor is processed.
     * i.e. when moving to html text editor or when content saved
     */
    editor.on('PostProcess', function(event) {
        event.content = restoreResponsiveImageShortcodes(event.content);
    });

    /**
     * Replace [responsiveimage ... ] shortcodes with the placeholder image in the tinymce visual editor
     * 
     * @param {type} content The content of the tinymce editor
     * @returns String The new content for the tinymceeditor
     */
    function replaceResponsiveImageShortcodes(content) {
        return content.replace(/\[responsiveimage([^\]]*)\]/g, function(match, attrs) {
            placeholder = getAttr(attrs, 'placeholder');

            return '<img src="' + tinymce.documentBaseURL + '../wp-content/uploads/' + placeholder + '" class="responsiveimage mceItem" title="Responsive image" data-shortcode="responsiveimage' + tinymce.DOM.encode(attrs) + '" />';
        });
    }

    /**
     * Return the placeholder <img /> tags to [responsiveimage ... ] shortcodes
     */
    function restoreResponsiveImageShortcodes(content) {
        return content.replace(/(?:<p[^>]*>)*(<img[^>]+>)(?:<\/p>)*/g, function(a, imageHtml) {
            var cls = getAttr(imageHtml, 'class');

            if (cls.indexOf('responsiveimage') !== -1)
                return '[' + tinymce.trim(getAttr(imageHtml, 'data-shortcode')) + ']';

            return a;
        });

    }

    /**
     * Get the value of an attribute given an html-style string of attributes
     * e.g. attr1="value" attr2="value2"
     * 
     * @param {type} s
     * @param {type} n
     * @returns {String}
     */
    function getAttr(s, n) {
        n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
        return n ? tinymce.DOM.decode(n[1]) : '';
    }

});