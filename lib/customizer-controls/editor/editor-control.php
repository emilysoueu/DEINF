<?php
/**
 * Customize for Editor, extend the WP customizer
 *
 */
if ( ! defined( 'ABSPATH' ) ) { 
	exit;
}

function onetone_editor_customize_register() {

class Onetone_Customize_Editor_Control extends WP_Customize_Control {
	
	public $type = 'onetone-editor';
	/**
	 * Constructor.
	 *
	 * Supplied `$args` override class property defaults.
	 *
	 * If `$args['settings']` is not defined, use the $id as the setting ID.
	 *
	 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
	 * @param string               $id      Control ID.
	 * @param array                $args    Optional. Arguments to override class property defaults.
	 */
	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );
		if ( ! empty( $args['editor_settings'] ) ) {
			$this->input_attrs['data-editor'] = wp_json_encode( $args['editor_settings'] );
		}
	}
	/**
	 * Render the control's content.
	 *
	 */
	public function render_content() {
		?>
		<label>
			<?php if ( ! empty( $this->label ) ) : ?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>
			<textarea type="hidden" <?php $this->link(); ?> style="display:none;" id="<?php echo esc_attr( $this->id ); ?>"class='editorfield' ><?php echo esc_textarea( $this->value() ); ?></textarea>
			<a onclick="javascript:WPEditorWidget.toggleEditor('<?php echo esc_attr($this->id); ?>');" class="button edit-content-button"><?php esc_attr_e( '(Edit)', 'onetone' ); ?></a>
		</label>
 		<?php
	}
	
	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {
		wp_enqueue_style( 'onetone_editor_css', get_template_directory_uri() . '/lib/customizer-controls/editor/assets/css/editor.css', array(), '' );
		wp_enqueue_script(
			'onetone_editor_js', get_template_directory_uri() . '/lib/customizer-controls/editor/assets/js/editor.js', array(
				'jquery',
				'customize-preview',
			), '', true
		);		
	}
}

}

add_action( 'customize_register', 'onetone_editor_customize_register' );
