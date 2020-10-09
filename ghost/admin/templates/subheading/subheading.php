<?php if ( ! defined( 'ABSPATH' ) ) { die; } 
if( ! class_exists( 'GHOST_Field_subheading' ) ) {
class GHOST_Field_subheading extends GHOST_Fields {

public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
parent::__construct( $field, $value, $unique, $where, $parent );
}

public function render() {

echo ( ! empty( $this->field['content'] ) ) ? $this->field['content'] : '';

}

}
}
