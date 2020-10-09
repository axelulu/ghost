<?php if ( ! defined( 'ABSPATH' ) ) { die; }
if( ! class_exists( 'GHOST_Field_sorter' ) ) {
class GHOST_Field_sorter extends GHOST_Fields {

public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
parent::__construct( $field, $value, $unique, $where, $parent );
}

public function render() {

$args = wp_parse_args( $this->field, array(
'disabled'       => true,
'enabled_title'  => '开启的选项',
'disabled_title' => '关闭的选项',
) );

echo $this->field_before();

$this->value      = ( ! empty( $this->value ) ) ? $this->value : $this->field['default'];
$enabled_options  = ( ! empty( $this->value['enabled'] ) ) ? $this->value['enabled'] : array();
$disabled_options = ( ! empty( $this->value['disabled'] ) ) ? $this->value['disabled'] : array();

echo ( $args['disabled'] ) ? '<div class="ghost-panel-modules">' : '';

echo ( ! empty( $args['enabled_title'] ) ) ? '<div class="ghost-panel-sorter-title">'. $args['enabled_title'] .'</div>' : '';
echo '<ul class="ghost-panel-enabled">';
if( ! empty( $enabled_options ) ) {
foreach( $enabled_options as $key => $value ) {
echo '<li><input type="hidden" name="'. $this->field_name( '[enabled]['. $key .']' ) .'" value="'. $value .'"/><label>'. $value .'</label></li>';
}
}
echo '</ul>';

// Check for hide/show disabled section
if( $args['disabled'] ) {

echo '</div>';

echo '<div class="ghost-panel-modules">';
echo ( ! empty( $args['disabled_title'] ) ) ? '<div class="ghost-panel-sorter-title">'. $args['disabled_title'] .'</div>' : '';
echo '<ul class="ghost-panel-disabled">';
if( ! empty( $disabled_options ) ) {
foreach( $disabled_options as $key => $value ) {
echo '<li><input type="hidden" name="'. $this->field_name( '[disabled]['. $key .']' ) .'" value="'. $value .'"/><label>'. $value .'</label></li>';
}
}
echo '</ul>';
echo '</div>';

}

echo '<div class="clear"></div>';

echo $this->field_after();

}

public function enqueue() {

if( ! wp_script_is( 'jquery-ui-sortable' ) ) {
wp_enqueue_script( 'jquery-ui-sortable' );
}

}

}
}
