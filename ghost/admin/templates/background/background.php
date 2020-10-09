<?php if ( ! defined( 'ABSPATH' ) ) { die; }
if( ! class_exists( 'GHOST_Field_background' ) ) {
class GHOST_Field_background extends GHOST_Fields {

public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
parent::__construct( $field, $value, $unique, $where, $parent );
}

public function render() {

$args = wp_parse_args( $this->field, array(
'background_color'              => true,
'background_image'              => true,
'background_position'           => true,
'background_repeat'             => true,
'background_attachment'         => true,
'background_size'               => true,
'background_origin'             => false,
'background_clip'               => false,
'background_blend-mode'         => false,
'background_gradient'           => false,
'background_gradient_color'     => true,
'background_gradient_direction' => true,
'background_image_preview'      => true,
'background_image_library'      => 'image',
'background_image_placeholder'  => 'https://',
) );

$default_values = array(
'background-color'              => '',
'background-image'              => '',
'background-position'           => '',
'background-repeat'             => '',
'background-attachment'         => '',
'background-size'               => '',
'background-origin'             => '',
'background-clip'               => '',
'background-blend-mode'         => '',
'background-gradient-color'     => '',
'background-gradient-direction' => '',
);

$this->value = wp_parse_args( $this->value, $default_values );

echo $this->field_before();

//
// Background Color
if( ! empty( $args['background_color'] ) ) {

echo '<div class="ghost-panel--block ghost-panel--color">';
echo ( ! empty( $args['background_gradient'] ) ) ? '<div class="ghost-panel--title">From</div>' : '';

GHOST::field( array(
'id'   => 'background-color',
'type' => 'color',
), $this->value['background-color'], $this->field_name(), 'field/background' );

echo '</div>';

}

//
// Background Gradient Color
if( ! empty( $args['background_gradient_color'] ) && ! empty( $args['background_gradient'] ) ) {

echo '<div class="ghost-panel--block ghost-panel--color">';
echo ( ! empty( $args['background_gradient'] ) ) ? '<div class="ghost-panel--title">To</div>' : '';

GHOST::field( array(
'id'   => 'background-gradient-color',
'type' => 'color',
), $this->value['background-gradient-color'], $this->field_name(), 'field/background' );

echo '</div>';

}

//
// Background Gradient Direction
if( ! empty( $args['background_gradient_direction'] ) && ! empty( $args['background_gradient'] ) ) {

echo '<div class="ghost-panel--block ghost-panel--gradient">';
echo ( ! empty( $args['background_gradient'] ) ) ? '<div class="ghost-panel--title">Direction</div>' : '';

GHOST::field( array(
'id'          => 'background-gradient-direction',
'type'        => 'select',
'options'     => array(
''          => 'Gradient Direction',
'to bottom' => '&#8659; top to bottom',
'to right'  => '&#8658; left to right',
'135deg'    => '&#8664; corner top to right',
'-135deg'   => '&#8665; corner top to left',
),
), $this->value['background-gradient-direction'], $this->field_name(), 'field/background' );

echo '</div>';

}

echo '<div class="clear"></div>';

//
// Background Image
if( ! empty( $args['background_image'] ) ) {

echo '<div class="ghost-panel--block ghost-panel--media">';

GHOST::field( array(
'id'          => 'background-image',
'type'        => 'upload',
'library'     => $args['background_image_library'],
'preview'     => $args['background_image_preview'],
'placeholder' => $args['background_image_placeholder']
), $this->value['background-image'], $this->field_name(), 'field/background' );

echo '</div>';

echo '<div class="clear"></div>';

}

//
// Background Position
if( ! empty( $args['background_position'] ) ) {
echo '<div class="ghost-panel--block ghost-panel--select">';

GHOST::field( array(
'id'              => 'background-position',
'type'            => 'select',
'options'         => array(
''              => '背景图定位',
'left top'      => 'Left Top',
'left center'   => 'Left Center',
'left bottom'   => 'Left Bottom',
'center top'    => 'Center Top',
'center center' => 'Center Center',
'center bottom' => 'Center Bottom',
'right top'     => 'Right Top',
'right center'  => 'Right Center',
'right bottom'  => 'Right Bottom',
),
), $this->value['background-position'], $this->field_name(), 'field/background' );

echo '</div>';

}

//
// Background Repeat
if( ! empty( $args['background_repeat'] ) ) {
echo '<div class="ghost-panel--block ghost-panel--select">';

GHOST::field( array(
'id'          => 'background-repeat',
'type'        => 'select',
'options'     => array(
''          => '背景平铺模式',
'repeat'    => '垂直和水平方向平铺-repeat',
'no-repeat' => '不平铺-no-repeat',
'repeat-x'  => '水平方向平铺-repeat-x',
'repeat-y'  => '垂直方向平铺-repeat-y',
),
), $this->value['background-repeat'], $this->field_name(), 'field/background' );

echo '</div>';

}

//
// Background Attachment
if( ! empty( $args['background_attachment'] ) ) {
echo '<div class="ghost-panel--block ghost-panel--select">';

GHOST::field( array(
'id'       => 'background-attachment',
'type'     => 'select',
'options'  => array(
''       => '背景图依附模式',
'scroll' => '随页面滚动-scroll',
'fixed'  => '背景图固定-fixed',
),
), $this->value['background-attachment'], $this->field_name(), 'field/background' );

echo '</div>';

}

//
// Background Size
if( ! empty( $args['background_size'] ) ) {
echo '<div class="ghost-panel--block ghost-panel--select">';

GHOST::field( array(
'id'        => 'background-size',
'type'      => 'select',
'options'   => array(
''        => '背景图像的大小',
'cover'   => '覆盖-Cover',
'contain' => '扩大至最大尺寸-Contain',
),
), $this->value['background-size'], $this->field_name(), 'field/background' );

echo '</div>';

}

//
// Background Origin
if( ! empty( $args['background_origin'] ) ) {
echo '<div class="ghost-panel--block ghost-panel--select">';

GHOST::field( array(
'id'            => 'background-origin',
'type'          => 'select',
'options'       => array(
''            => 'Background Origin',
'padding-box' => 'Padding Box',
'border-box'  => 'Border Box',
'content-box' => 'Content Box',
),
), $this->value['background-origin'], $this->field_name(), 'field/background' );

echo '</div>';

}

//
// Background Clip
if( ! empty( $args['background_clip'] ) ) {
echo '<div class="ghost-panel--block ghost-panel--select">';

GHOST::field( array(
'id'            => 'background-clip',
'type'          => 'select',
'options'       => array(
''            => 'Background Clip',
'border-box'  => 'Border Box',
'padding-box' => 'Padding Box',
'content-box' => 'Content Box',
),
), $this->value['background-clip'], $this->field_name(), 'field/background' );

echo '</div>';

}

//
// Background Blend Mode
if( ! empty( $args['background_blend_mode'] ) ) {
echo '<div class="ghost-panel--block ghost-panel--select">';

GHOST::field( array(
'id'            => 'background-blend-mode',
'type'          => 'select',
'options'       => array(
''            => 'Background Blend Mode',
'normalize_whitespace( $str )'      => 'Normal',
'multiply'    => 'Multiply',
'screen'      => 'Screen',
'overlay'     => 'Overlay',
'darken'      => 'Darken',
'lighten'     => 'Lighten',
'color-dodge' => 'Color Dodge',
'saturation'  => 'Saturation',
'color'       => 'Color',
'luminosity'  => 'Luminosity',
),
), $this->value['background-blend-mode'], $this->field_name(), 'field/background' );

echo '</div>';

}

echo '<div class="clear"></div>';

echo $this->field_after();

}

public function output() {

$output    = '';
$bg_image  = array();
$important = ( ! empty( $this->field['output_important'] ) ) ? '!important' : '';
$element   = ( is_array( $this->field['output'] ) ) ? join( ',', $this->field['output'] ) : $this->field['output'];

// Background image and gradient
$background_color        = ( ! empty( $this->value['background-color']              ) ) ? $this->value['background-color']              : '';
$background_gd_color     = ( ! empty( $this->value['background-gradient-color']     ) ) ? $this->value['background-gradient-color']     : '';
$background_gd_direction = ( ! empty( $this->value['background-gradient-direction'] ) ) ? $this->value['background-gradient-direction'] : '';
$background_image        = ( ! empty( $this->value['background-image']['url']       ) ) ? $this->value['background-image']['url']       : '';


if( $background_color && $background_gd_color ) {
$gd_direction   = ( $background_gd_direction ) ? $background_gd_direction .',' : '';
$bg_image[] = 'linear-gradient('. $gd_direction . $background_color .','. $background_gd_color .')';
}

if( $background_image ) {
$bg_image[] = 'url('. $background_image .')';
}

if( ! empty( $bg_image ) ) {
$output .= 'background-image:'. implode( ',', $bg_image ) . $important .';';
}

// Common background properties
$properties = array( 'color', 'position', 'repeat', 'attachment', 'size', 'origin', 'clip', 'blend-mode' );

foreach( $properties as $property ) {
$property = 'background-'. $property;
if( ! empty( $this->value[$property] ) ) {
$output .= $property .':'. $this->value[$property] . $important .';';
}
}

if( $output ) {
$output = $element .'{'. $output .'}';
}

$this->parent->output_css .= $output;

return $output;

}

}
}
