<?php if ( ! defined( 'ABSPATH' ) ) { die; }
if( ! class_exists( 'GHOST_Field_select' ) ) {
class GHOST_Field_select extends GHOST_Fields {

public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
parent::__construct( $field, $value, $unique, $where, $parent );
}

public function render() {

$args = wp_parse_args( $this->field, array(
'chosen'      => false,
'multiple'    => false,
'placeholder' => '',
) );

$this->value = ( is_array( $this->value ) ) ? $this->value : array_filter( (array) $this->value );

echo $this->field_before();

if( ! empty( $this->field['options'] ) ) {

$options          = ( is_array( $this->field['options'] ) ) ? $this->field['options'] : $this->field_data( $this->field['options'] );
$multiple_name    = ( $args['multiple'] ) ? '[]' : '';
$multiple_attr    = ( $args['multiple'] ) ? ' multiple="multiple"' : '';
$chosen_rtl       = ( is_rtl() ) ? ' chosen-rtl' : '';
$chosen_attr      = ( $args['chosen'] ) ? ' class="ghost-panel-chosen'. $chosen_rtl .'"' : '';
$placeholder_attr = ( $args['chosen'] && $args['placeholder'] ) ? ' data-placeholder="'. $args['placeholder'] .'"' : '';

if( ! empty( $options ) ) {

echo '<select name="'. $this->field_name( $multiple_name ) .'"'. $multiple_attr . $chosen_attr . $placeholder_attr . $this->field_attributes() .'>';

if( $args['placeholder'] && empty( $args['multiple'] ) ) {
if( ! empty( $args['chosen'] ) ) {
echo '<option value=""></option>';
} else {
echo '<option value="">'. $args['placeholder'] .'</option>';
}
}

foreach ( $options as $option_key => $option ) {

if( is_array( $option ) && ! empty( $option ) ) {

echo '<optgroup label="'. $option_key .'">';

foreach( $option as $sub_key => $sub_value ) {
$selected = ( in_array( $sub_key, $this->value ) ) ? ' selected' : '';
echo '<option value="'. $sub_key .'" '. $selected .'>'. $sub_value .'</option>';
}

echo '</optgroup>';

} else {
$selected = ( in_array( $option_key, $this->value ) ) ? ' selected' : '';
echo '<option value="'. $option_key .'" '. $selected .'>'. $option .'</option>';
}

}

echo '</select>';

} else {

echo ( ! empty( $this->field['empty_message'] ) ) ? $this->field['empty_message'] : '暂没有数据';

}

}

echo $this->field_after();

}

}
}
