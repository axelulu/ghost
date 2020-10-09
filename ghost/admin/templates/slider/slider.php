<?php if ( ! defined( 'ABSPATH' ) ) { die; }
if( ! class_exists( 'GHOST_Field_slider' ) ) {
class GHOST_Field_slider extends GHOST_Fields {

public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
parent::__construct( $field, $value, $unique, $where, $parent );
}

public function render() {

$args = wp_parse_args( $this->field, array(
'max'  => 100,
'min'  => 0,
'step' => 1,
'unit' => '',
) );

echo $this->field_before();

echo '<div class="ghost-panel-table">';
echo '<div class="ghost-panel-table-cell ghost-panel-table-expanded"><div class="ghost-panel-slider-ui"></div></div>';
echo '<div class="ghost-panel-table-cell ghost-panel-nowrap">';
echo '<input type="text" name="'. $this->field_name() .'" value="'. $this->value .'"'. $this->field_attributes() .' data-max="'. $args['max'] .'" data-min="'. $args['min'] .'" data-step="'. $args['step'] .'" class="ghost-panel-number" />';
echo ( ! empty( $args['unit'] ) ) ? '<em>'. $args['unit'] .'</em>' : '';
echo '</div>';
echo '</div>';

echo $this->field_after();

}

public function enqueue() {

if( ! wp_script_is( 'jquery-ui-slider' ) ) {
wp_enqueue_script( 'jquery-ui-slider' );
}

}

public function output() {

$output    = '';
$elements  = ( is_array( $this->field['output'] ) ) ? $this->field['output'] : array_filter( (array) $this->field['output'] );
$important = ( ! empty( $this->field['output_important'] ) ) ? '!important' : '';
$mode      = ( ! empty( $this->field['output_mode'] ) ) ? $this->field['output_mode'] : 'width';
$unit      = ( ! empty( $this->field['unit'] ) ) ? $this->field['unit'] : 'px';

if( ! empty( $elements ) && isset( $this->value ) && $this->value !== '' ) {
foreach( $elements as $key_property => $element ) {
if( is_numeric( $key_property ) ) {
if( $mode ) {
$output = implode( ',', $elements ) .'{'. $mode .':'. $this->value . $unit . $important .';}';
}
break;
} else {
$output .= $element .'{'. $key_property .':'. $this->value . $unit . $important .'}';
}
}
}

$this->parent->output_css .= $output;

return $output;

}

}
}
