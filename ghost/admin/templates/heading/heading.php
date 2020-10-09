<?php if ( ! defined( 'ABSPATH' ) ) { die; }
if( ! class_exists( 'GHOST_Field_heading' ) ) {
class GHOST_Field_heading extends GHOST_Fields {

public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
parent::__construct( $field, $value, $unique, $where, $parent );
}

public function render() {

echo ( ! empty( $this->field['content'] ) ) ? $this->field['content'] : '';

}

}
}
