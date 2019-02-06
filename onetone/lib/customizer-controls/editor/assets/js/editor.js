/* global tinyMCE */
/* global wp */

/* exported WPEditorWidget */
var WPEditorWidget = {

    /**
     * Current content id
     *
     * @var string Current content id.
     */
    currentContentId: '',

    /**
     * Z index for Overlay
     *
     * @var int Z index for Overlay.
     */
    wpFullOverlayOriginalZIndex: 0,

    /**
     * Visible or not
     *
     * @var bool Visible or not.
     */
    isVisible: false,

    /**
     * Show/Hide editor
     */
    toggleEditor: function(contentId) {
        if (this.isVisible === true) {
            this.hideEditor();
        } else {
            this.showEditor(contentId);
        }
    },

    showEditor: function(contentId) {
        this.isVisible = true;
        var overlay = jQuery('.wp-full-overlay');

        jQuery('body.wp-customizer #onetone-editor-container').fadeIn(100).animate({ 'bottom': '0' });

        this.currentContentId = contentId;
        this.wpFullOverlayOriginalZIndex = parseInt(overlay.css('zIndex'));
        overlay.css({ zIndex: 49000 });

        var editor = tinyMCE.EditorManager.get('onetone-page-editor');
        var content = jQuery("textarea[id='" + contentId + "']").val();

        if (typeof editor === 'object' && editor !== null) {
            editor.setContent(content);
        }
        jQuery('#onetone-page-editor').val(content);
    },

    /**
     * Hide editor
     */
    hideEditor: function() {
        this.isVisible = false;
        jQuery('body.wp-customizer #onetone-editor-container').animate({ 'bottom': '-650px' }).fadeOut();
        jQuery('.wp-full-overlay').css({ zIndex: this.wpFullOverlayOriginalZIndex });
    },

    /**
     * Update widget and close the editor
     */
    updateWidgetAndCloseEditor: function() {

        jQuery('#onetone-page-editor-tmce').trigger('click');
        var editor = tinyMCE.EditorManager.get('onetone-page-editor');
        var content = editor.getContent();

        if (typeof editor === 'undefined' || editor === null || editor.isHidden()) {
            content = jQuery('#onetone-page-editor').val();
        }

        var contentId = jQuery("textarea[id='" + this.currentContentId + "']");
        contentId.html(content);

        if (contentId.attr('class') === 'editorfield') {
            var controlid = contentId.data('customize-setting-link');
            setTimeout(
                function() {
                    wp.customize(
                        controlid,
                        function(obj) {
                            obj.set(editor.getContent());
							var customize = wp.customize;
							customize.instance(controlid).set(editor.getContent());
        					customize.instance(controlid).previewer.refresh();
                        }
                    );
                }, 1000
            );
        }

        this.hideEditor();
    }

};

jQuery(document).ready(
    function() {
        jQuery('.customize-section-back').on(
            'click',
            function() {
                WPEditorWidget.hideEditor();
            }
        );

        var customize = wp.customize;
        customize.previewer.bind(
            'trigger-close-editor',
            function(data) {
                if (data === true) {
                    WPEditorWidget.hideEditor();
                }
            }
        );

    }
);