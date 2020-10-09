<?php if ( ! defined( 'ABSPATH' ) ) { die; }
if( ! class_exists( 'GHOST_Field_group' ) ) {
class GHOST_Field_group extends GHOST_Fields {

public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
parent::__construct( $field, $value, $unique, $where, $parent );
}

public function render() {

$args = wp_parse_args( $this->field, array(
'max'                    => 0,
'min'                    => 0,
'fields'                 => array(),
'button_title'           => '添加',
'accordion_title_prefix' => '',
'accordion_title_number'  => false,
'accordion_title_auto'   => true,
) );

$title_prefix = ( ! empty( $args['accordion_title_prefix'] ) ) ? $args['accordion_title_prefix'] : '';
$title_number = ( ! empty( $args['accordion_title_number'] ) ) ? true : false;
$title_auto   = ( ! empty( $args['accordion_title_auto'] ) ) ? true : false;

if( ! empty( $this->parent ) && preg_match( '/'. preg_quote( '['. $this->field['id'] .']' ) .'/', $this->parent ) ) {

echo '<div class="ghost-panel-notice ghost-panel-notice-danger">字段ID重复！</div>';

} else {

echo $this->field_before();

echo '<div class="ghost-panel-cloneable-item ghost-panel-cloneable-hidden">';

echo '<div class="ghost-panel-cloneable-helper">';
echo '<i class="ghost-panel-cloneable-sort fa fa-arrows"></i>';
echo '<i class="ghost-panel-cloneable-clone fa fa-clone"></i>';
echo '<i class="ghost-panel-cloneable-remove ghost-panel-confirm fa fa-times" data-confirm="你确定要删除这个选项吗？"></i>';
echo '</div>';

echo '<h4 class="ghost-panel-cloneable-title">';
echo '<span class="ghost-panel-cloneable-text">';
echo ( $title_number ) ? '<span class="ghost-panel-cloneable-title-number"></span>' : '';
echo ( $title_prefix ) ? '<span class="ghost-panel-cloneable-title-prefix">'. $title_prefix .'</span>' : '';
echo ( $title_auto ) ? '<span class="ghost-panel-cloneable-value"><span class="ghost-panel-cloneable-placeholder"></span></span>' : '';
echo '</span>';
echo '</h4>';

echo '<div class="ghost-panel-cloneable-content">';
foreach ( $this->field['fields'] as $field ) {

$field_parent  = $this->parent .'['. $this->field['id'] .']';
$field_default = ( isset( $field['default'] ) ) ? $field['default'] : '';

GHOST::field( $field, $field_default, '_nonce', 'field/group', $field_parent );

}
echo '</div>';

echo '</div>';

echo '<div class="ghost-panel-cloneable-wrapper ghost-panel-data-wrapper" data-title-number="'. $title_number .'" data-unique-id="'. $this->unique .'" data-field-id="['. $this->field['id'] .']" data-max="'. $args['max'] .'" data-min="'. $args['min'] .'">';

if( ! empty( $this->value ) ) {

$num = 0;

foreach ( $this->value as $value ) {

$first_id    = ( isset( $this->field['fields'][0]['id'] ) ) ? $this->field['fields'][0]['id'] : '';
$first_value = ( isset( $value[$first_id] ) ) ? $value[$first_id] : '';

echo '<div class="ghost-panel-cloneable-item">';

echo '<div class="ghost-panel-cloneable-helper">';
echo '<i class="ghost-panel-cloneable-sort fa fa-arrows"></i>';
echo '<i class="ghost-panel-cloneable-clone fa fa-clone"></i>';
echo '<i class="ghost-panel-cloneable-remove ghost-panel-confirm fa fa-times" data-confirm="你确定要删除这个选项吗？"></i>';
echo '</div>';

echo '<h4 class="ghost-panel-cloneable-title">';
echo '<span class="ghost-panel-cloneable-text">';
echo ( $title_number ) ? '<span class="ghost-panel-cloneable-title-number">'. ( $num+1 ) .'.</span>' : '';
echo ( $title_prefix ) ? '<span class="ghost-panel-cloneable-title-prefix">'. $title_prefix .'</span>' : '';
echo ( $title_auto ) ? '<span class="ghost-panel-cloneable-value">' . $first_value .'</span>' : '';
echo '</span>';
echo '</h4>';

echo '<div class="ghost-panel-cloneable-content">';

foreach ( $this->field['fields'] as $field ) {

$field_parent  = $this->parent .'['. $this->field['id'] .']';
$field_unique = ( ! empty( $this->unique ) ) ? $this->unique .'['. $this->field['id'] .']['. $num .']' : $this->field['id'] .'['. $num .']';
$field_value  = ( isset( $field['id'] ) && isset( $value[$field['id']] ) ) ? $value[$field['id']] : '';

GHOST::field( $field, $field_value, $field_unique, 'field/group', $field_parent );

}

echo '</div>';

echo '</div>';

$num++;

}

}

echo '</div>';

echo '<div class="ghost-panel-cloneable-alert ghost-panel-cloneable-max">最多只能添加'.$args['max'].'个选项</div>';
echo '<div class="ghost-panel-cloneable-alert ghost-panel-cloneable-min">最少要添加'.$args['min'].'个选项</div>';

echo '<a href="#" class="button button-primary ghost-panel-cloneable-add">'. $args['button_title'] .'</a>';

echo $this->field_after();

}

}

public function enqueue() {

if( ! wp_script_is( 'jquery-ui-accordion' ) ) {
wp_enqueue_script( 'jquery-ui-accordion' );
}

if( ! wp_script_is( 'jquery-ui-sortable' ) ) {
wp_enqueue_script( 'jquery-ui-sortable' );
}

}

}
}
