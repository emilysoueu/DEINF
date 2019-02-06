<?php 

function onetone_page_editor() {
	?>
	<div id="onetone-editor-container" style="display: none;">
		<a class="close" href="javascript:WPEditorWidget.hideEditor();"><span class="icon"></span></a>
		<div class="editor">
			<?php
			$settings = array(
				'textarea_rows' => 55,
				'editor_height' => 260,
			);
			wp_editor( '', 'onetone-page-editor', $settings );
			?>
			<p><a href="javascript:WPEditorWidget.updateWidgetAndCloseEditor(true);" class="button button-primary"><?php _e( 'Save and close', 'onetone' ); ?></a></p>
		</div>
	</div>
	<?php
}

add_action( 'customize_controls_print_footer_scripts', 'onetone_page_editor', 1 );