<?php if ( ! defined( 'ABSPATH' ) ) { die; }
if(! class_exists('GHOST_Field_verify')){
class GHOST_Field_verify extends GHOST_Fields {
public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
parent::__construct( $field, $value, $unique, $where, $parent );
}
public function render(){
?>
<?php 
}
}
}