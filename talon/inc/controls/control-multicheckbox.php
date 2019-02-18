<?php
/**
 * Multicheckbox control
 *
 * @package Talon
 */ 


class Talon_Multiselect_Control extends WP_Customize_Control {
    public $type = 'multi-checkbox';

    public function render_content() {

        if ( empty( $this->choices ) )
        return;
        ?>
        <label>
        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <select class="widefat" <?php $this->link(); ?> style="min-height:170px;overflow:hidden;" multiple="multiple">
        <?php
        foreach ( $this->choices as $value => $label ) {
            $selected = ( in_array( $value, $this->value() ) ) ? selected( 1, 1, false ) : '';
            echo '<option value="' . esc_attr( $value ) . '"' . esc_attr( $selected ) . '>' . esc_html( $label ) . '</option>';
        }
    }
}