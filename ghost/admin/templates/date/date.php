<?php if ( ! defined( 'ABSPATH' ) ) { die; }
if( ! class_exists( 'GHOST_Field_date' ) ) {
class GHOST_Field_date extends GHOST_Fields {

public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
parent::__construct( $field, $value, $unique, $where, $parent );
}

public function render() {

$default_settings = array(
'dateFormat' => 'yy-mm-dd',
);

$settings = ( ! empty( $this->field['settings'] ) ) ? $this->field['settings'] : array();
$settings = wp_parse_args( $settings, $default_settings );

echo $this->field_before();

if( ! empty( $this->field['from_to'] ) ) {

$args = wp_parse_args( $this->field, array(
'text_from' => 'From',
'text_to'   => 'To',
) );

$value = wp_parse_args( $this->value, array(
'from' => '',
'to'   => '',
) );

echo '<label class="ghost-panel--from">'. $args['text_from'] .' <input type="text" name="'. $this->field_name('[from]') .'" value="'. $value['from'] .'"'. $this->field_attributes() .'/></label>';
echo '<label class="ghost-panel--to">'. $args['text_to'] .' <input type="text" name="'. $this->field_name('[to]') .'" value="'. $value['to'] .'"'. $this->field_attributes() .'/></label>';

} else {

echo '<input type="text" name="'. $this->field_name() .'" value="'. $this->value .'"'. $this->field_attributes() .'/>';

}

echo '<div class="ghost-panel-date-settings" data-settings="'. esc_attr( json_encode( $settings ) ) .'"></div>';

echo $this->field_after();

}

public function enqueue() {

if( ! wp_script_is( 'jquery-ui-datepicker' ) ) {
wp_enqueue_script( 'jquery-ui-datepicker' );
}

}

}
}
