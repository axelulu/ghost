<?php if ( ! defined( 'ABSPATH' ) ) { die; }
if( ! class_exists( 'GHOST_Field_sortable' ) ) {
class GHOST_Field_sortable extends GHOST_Fields {

public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
parent::__construct( $field, $value, $unique, $where, $parent );
}

public function render() {

echo $this->field_before();

echo '<div class="ghost-panel--sortable">';

$pre_sortby = array();
$pre_fields = array();

// Add array-keys to defined fields for sort by
foreach( $this->field['fields'] as $key => $field ) {
$pre_fields[$field['id']] = $field;
}

// Set sort by by saved-value or default-value
if( ! empty( $this->value ) ) {

foreach( $this->value as $key => $value ) {
$pre_sortby[$key] = $pre_fields[$key];
}

} else {

foreach( $pre_fields as $key => $value ) {
$pre_sortby[$key] = $value;
}

}

foreach( $pre_sortby as $key => $field ) {

echo '<div class="ghost-panel--sortable-item">';

echo '<div class="ghost-panel--sortable-content">';

$field_default = ( isset( $this->field['default'][$key] ) ) ? $this->field['default'][$key] : '';
$field_value   = ( isset( $this->value[$key] ) ) ? $this->value[$key] : $field_default;
$unique_id     = ( ! empty( $this->unique ) ) ? $this->unique .'['. $this->field['id'] .']' : $this->field['id'];

GHOST::field( $field, $field_value, $unique_id, 'field/sortable' );

echo '</div>';

echo '<div class="ghost-panel--sortable-helper"><i class="fa fa-arrows"></i></div>';

echo '</div>';

}

echo '</div>';

echo $this->field_after();

}

public function enqueue() {

if( ! wp_script_is( 'jquery-ui-sortable' ) ) {
wp_enqueue_script( 'jquery-ui-sortable' );
}

}

}
}
