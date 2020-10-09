<?php if ( ! defined( 'ABSPATH' ) ) { die; }
if( ! class_exists( 'GHOST_Field_notice' ) ) {
class GHOST_Field_notice extends GHOST_Fields {

public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
parent::__construct( $field, $value, $unique, $where, $parent );
}

public function render() {

$style = ( ! empty( $this->field['style'] ) ) ? $this->field['style'] : 'normal';

echo ( ! empty( $this->field['content'] ) ) ? '<div class="ghost-panel-notice ghost-panel-notice-'. $style .'">'. $this->field['content'] .'</div>' : '';

}

}
}
