<?php if ( ! defined( 'ABSPATH' ) ) { die; } 
if( ! class_exists( 'GHOST_Field_gallery' ) ) {
class GHOST_Field_gallery extends GHOST_Fields {

public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
parent::__construct( $field, $value, $unique, $where, $parent );
}

public function render() {

$args = wp_parse_args( $this->field, array(
'add_title'   => '创建相册',
'edit_title'  => '编辑相册',
'clear_title' => '移除',
) );

$hidden = ( empty( $this->value ) ) ? ' hidden' : '';

echo $this->field_before();

echo '<ul>';

if( ! empty( $this->value ) ) {

$values = explode( ',', $this->value );

foreach ( $values as $id ) {
$attachment = wp_get_attachment_image_src( $id, 'thumbnail' );
echo '<li><img src="'. $attachment[0] .'" alt="" /></li>';
}

}

echo '</ul>';
echo '<a href="#" class="button button-primary ghost-panel-button">'. $args['add_title'] .'</a>';
echo '<a href="#" class="button ghost-panel-edit-gallery'. $hidden .'">'. $args['edit_title'] .'</a>';
echo '<a href="#" class="button ghost-panel-warning-primary ghost-panel-clear-gallery'. $hidden .'">'. $args['clear_title'] .'</a>';
echo '<input type="text" name="'. $this->field_name() .'" value="'. $this->value .'"'. $this->field_attributes() .'/>';

echo $this->field_after();

}

}
}
