<?php if ( ! defined( 'ABSPATH' ) ) { die; }
if( ! class_exists( 'GHOST_Field_media' ) ) {
class GHOST_Field_media extends GHOST_Fields {

public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
parent::__construct( $field, $value, $unique, $where, $parent );
}

public function render() {

$args = wp_parse_args( $this->field, array(
'url'          => true,
'preview'      => true,
'library'      => array(),
'button_title' => '上传',
'remove_title' => '移除',
'preview_size' => 'thumbnail',
) );

$default_values = array(
'url'         => '',
'id'          => '',
'width'       => '',
'height'      => '',
'thumbnail'   => '',
'alt'         => '',
'title'       => '',
'description' => ''
);

$this->value  = wp_parse_args( $this->value, $default_values );

$library     = ( is_array( $args['library'] ) ) ? $args['library'] : array_filter( (array) $args['library'] );
$library     = ( ! empty( $library ) ) ? implode(',', $library ) : '';
$preview_src = ( $args['preview_size'] !== 'thumbnail' ) ? $this->value['url'] : $this->value['thumbnail'];
$hidden_url  = ( empty( $args['url'] ) ) ? ' hidden' : '';
$hidden_auto = ( empty( $this->value['url'] ) ) ? ' hidden' : '';
$placeholder = ( empty( $this->field['placeholder'] ) ) ? ' placeholder="请点击上传插入内容"' : '';

echo $this->field_before();

if( ! empty( $args['preview'] ) ) {
echo '<div class="ghost-panel--preview'. $hidden_auto .'">';
echo '<div class="ghost-panel-image-preview"><a href="#" class="ghost-panel--remove fa fa-times"></a><img src="'. $preview_src .'" class="ghost-panel--src" /></div>';
echo '</div>';
}

echo '<div class="ghost-panel--placeholder">';
echo '<input type="text" name="'. $this->field_name('[url]') .'" value="'. $this->value['url'] .'" class="ghost-panel--url'. $hidden_url .'" readonly="readonly"'. $this->field_attributes() . $placeholder .' />';
echo '<a href="#" class="button button-primary ghost-panel--button" data-library="'. esc_attr( $library ) .'" data-preview-size="'. esc_attr( $args['preview_size'] ) .'">'. $args['button_title'] .'</a>';
echo ( empty( $args['preview'] ) ) ? '<a href="#" class="button button-secondary ghost-panel-warning-primary ghost-panel--remove'. $hidden_auto .'">'. $args['remove_title'] .'</a>' : '';
echo '</div>';

echo '<input type="hidden" name="'. $this->field_name('[id]') .'" value="'. $this->value['id'] .'" class="ghost-panel--id"/>';
echo '<input type="hidden" name="'. $this->field_name('[width]') .'" value="'. $this->value['width'] .'" class="ghost-panel--width"/>';
echo '<input type="hidden" name="'. $this->field_name('[height]') .'" value="'. $this->value['height'] .'" class="ghost-panel--height"/>';
echo '<input type="hidden" name="'. $this->field_name('[thumbnail]') .'" value="'. $this->value['thumbnail'] .'" class="ghost-panel--thumbnail"/>';
echo '<input type="hidden" name="'. $this->field_name('[alt]') .'" value="'. $this->value['alt'] .'" class="ghost-panel--alt"/>';
echo '<input type="hidden" name="'. $this->field_name('[title]') .'" value="'. $this->value['title'] .'" class="ghost-panel--title"/>';
echo '<input type="hidden" name="'. $this->field_name('[description]') .'" value="'. $this->value['description'] .'" class="ghost-panel--description"/>';

echo $this->field_after();

}

}
}
