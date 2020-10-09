<?php if ( ! defined( 'ABSPATH' ) ) { die; } 
if( ! class_exists( 'GHOST_Field_radio' ) ) {
class GHOST_Field_radio extends GHOST_Fields {

public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
parent::__construct( $field, $value, $unique, $where, $parent );
}

public function render() {

$args = wp_parse_args( $this->field, array(
'inline' => false,
) );

$inline_class = ( $args['inline'] ) ? ' class="ghost-panel--inline-list"' : '';

echo $this->field_before();

if( isset( $this->field['options'] ) ) {

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
$checked = ( $sub_key == $this->value ) ? ' checked' : '';
echo '<li><label><input type="radio" name="'. $this->field_name() .'" value="'. $sub_key .'"'. $this->field_attributes() . $checked .'/> '. $sub_value .'</label></li>';
}
echo '</ul>';
echo '</li>';

} else {

$checked = ( $option_key == $this->value ) ? ' checked' : '';
echo '<li><label><input type="radio" name="'. $this->field_name() .'" value="'. $option_key .'"'. $this->field_attributes() . $checked .'/> '. $option_value .'</label></li>';

}

}
echo '</ul>';

} else {

echo ( ! empty( $this->field['empty_message'] ) ) ? $this->field['empty_message'] : '暂没有数据';

}

} else {
$label = ( isset( $this->field['label'] ) ) ? $this->field['label'] : '';
echo '<label><input type="radio" name="'. $this->field_name() .'" value="1"'. $this->field_attributes() . checked( $this->value, 1, false ) .'/> '. $label .'</label>';
}

echo $this->field_after();

}

}
}
