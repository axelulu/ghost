<?php if ( ! defined( 'ABSPATH' ) ) { die; } 

if( ! class_exists( 'GHOST_Field_checkbox' ) ) {
class GHOST_Field_checkbox extends GHOST_Fields {

public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
parent::__construct( $field, $value, $unique, $where, $parent );
}

public function render() {

$args = wp_parse_args( $this->field, array(
'inline' => false,
) );

$inline_class = ( $args['inline'] ) ? ' class="ghost-panel--inline-list"' : '';

echo $this->field_before();

if( ! empty( $this->field['options'] ) ) {

$value   = ( is_array( $this->value ) ) ? $this->value : array_filter( (array) $this->value );
$options = $this->field['options'];
$options = ( is_array( $options ) ) ? $options : array_filter( $this->field_data( $options ) );

if( ! empty( $options ) ) {

echo '<ul'. $inline_class .'>';
foreach ( $options as $option_key => $option_value ) {

if( is_array( $option_value ) && ! empty( $option_value ) ) {

echo '<li>';
echo '<ul>';
echo '<li><strong>'. $option_key .'</strong></li>';
foreach( $option_value as $sub_key => $sub_value ) {
$checked = ( in_array( $sub_key, $value ) ) ? ' checked' : '';
echo '<li><label><input type="checkbox" name="'. $this->field_name( '[]' ) .'" value="'. $sub_key .'"'. $this->field_attributes() . $checked .'/> '. $sub_value .'</label></li>';
}
echo '</ul>';
echo '</li>';

} else {

$checked = ( in_array( $option_key, $value ) ) ? ' checked' : '';
echo '<li><label><input type="checkbox" name="'. $this->field_name( '[]' ) .'" value="'. $option_key .'"'. $this->field_attributes() . $checked .'/> '. $option_value .'</label></li>';

}

}
echo '</ul>';

} else {

echo ( ! empty( $this->field['empty_message'] ) ) ? $this->field['empty_message'] : '暂没有数据';

}

} else {

echo '<label class="ghost-panel-checkbox">';
echo '<input type="hidden" name="'. $this->field_name() .'" value="'. $this->value .'" class="ghost-panel--input"'. $this->field_attributes() .'/>';
echo '<input type="checkbox" class="ghost-panel--checkbox"'. checked( $this->value, 1, false ) .'/>';
echo ( ! empty( $this->field['label'] ) ) ? ' '. $this->field['label'] : '';
echo '</label>';

}

echo $this->field_after();

}

}
}
