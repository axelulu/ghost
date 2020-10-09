<?php if ( ! defined( 'ABSPATH' ) ) { die; } 
if( ! class_exists( 'GHOST_Field_submessage' ) ) {
class GHOST_Field_submessage extends GHOST_Fields {

public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
parent::__construct( $field, $value, $unique, $where, $parent );
}

public function render() {

$style = ( ! empty( $this->field['style'] ) ) ? $this->field['style'] : 'normal';

echo '<div class="ghost-panel-submessage ghost-panel-submessage-'. $style .'">'. $this->field['content'] .'</div>';

}

}
}
