<?php if ( ! defined( 'ABSPATH' ) ) { die; } 
if( ! class_exists( 'GHOST_Field_content' ) ) {
class GHOST_Field_content extends GHOST_Fields {

public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
parent::__construct( $field, $value, $unique, $where, $parent );
}

public function render() {
echo $this->field['content'];
}

}
}
