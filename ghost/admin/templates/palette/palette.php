<?php if ( ! defined( 'ABSPATH' ) ) { die; }
if( ! class_exists( 'GHOST_Field_palette' ) ) {
class GHOST_Field_palette extends GHOST_Fields {

public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
parent::__construct( $field, $value, $unique, $where, $parent );
}

public function render() {

$palette = ( ! empty( $this->field['options'] ) ) ? $this->field['options'] : array();

echo $this->field_before();

if( ! empty( $palette ) ) {

echo '<div class="ghost-panel-siblings ghost-panel--palettes">';

foreach ( $palette as $key => $colors ) {

$active  = ( $key === $this->value ) ? ' ghost-panel--active' : '';
$checked = ( $key === $this->value ) ? ' checked' : '';

echo '<div class="ghost-panel--sibling ghost-panel--palette'. $active .'">';

if( ! empty( $colors ) ) {

foreach( $colors as $color ) {

echo '<span style="background-color: '. $color .';"></span>';

}

}

echo '<input type="radio" name="'. $this->field_name() .'" value="'. $key .'"'. $this->field_attributes() . $checked .'/>';
echo '</div>';

}

echo '</div>';

}

echo '<div class="clear"></div>';

echo $this->field_after();

}

}
}
