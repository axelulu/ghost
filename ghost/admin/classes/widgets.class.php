<?php 
//Author URI:https://ghost.cn
if( ! class_exists( 'GHOST_Widget' ) ) {
class GHOST_Widget extends WP_Widget {


public $unique  = '';
public $args    = array(
'title'       => '',
'classname'   => '',
'description' => '',
'width'       => '',
'defaults'    => array(),
'fields'      => array(),
'class'       => '',
);

public function __construct( $key, $params ) {

$widget_ops  = array();
$control_ops = array();

$this->unique = $key;
$this->args   = apply_filters( "csf_{$this->unique}_args", wp_parse_args( $params, $this->args ), $this );


if( ! empty( $this->args['width'] ) ) {
$control_ops['width'] = $this->args['width'];
}


if( ! empty( $this->args['description'] ) ) {
$widget_ops['description'] = $this->args['description'];
}

if( ! empty( $this->args['classname'] ) ) {
$widget_ops['classname'] = $this->args['classname'];
}


$widget_ops  = apply_filters( "csf_{$this->unique}_widget_ops", $widget_ops, $this );
$control_ops = apply_filters( "csf_{$this->unique}_control_ops", $control_ops, $this );

parent::__construct( $this->unique, $this->args['title'], $widget_ops, $control_ops );

}


public static function instance( $key, $params = array() ) {
return new self( $key, $params );
}


public function widget( $args, $instance ) {
call_user_func( $this->unique, $args, $instance );
}


public function get_default( $field, $options = array() ) {

$default = ( isset( $this->args['defaults'][$field['id']] ) ) ? $this->args['defaults'][$field['id']] : '';
$default = ( isset( $field['default'] ) ) ? $field['default'] : $default;
$default = ( isset( $options[$field['id']] ) ) ? $options[$field['id']] : $default;

return $default;

}


public function form( $instance ) {

if( ! empty( $this->args['fields'] ) ) {

$class = ( $this->args['class'] ) ? ' '. $this->args['class'] : '';

echo '<div class="csf ghost-panel-widgets ghost-panel-fields'. $class .'">';

foreach( $this->args['fields'] as $field ) {

$field_value  = '';
$field_unique = '';

if( ! empty( $field['id'] ) ) {

$field_value  = $this->get_default( $field, $instance );
$field_unique = 'widget-' . $this->unique . '[' . $this->number . ']';

if( $field['id'] === 'title' ) {
$field['attributes']['id'] = 'widget-'. $this->unique .'-'. $this->number .'-title';
}

}

GHOST::field( $field, $field_value, $field_unique );

}

echo '</div>';

}

}


public function update( $new_instance, $old_instance ) {

$new_instance = apply_filters( "csf_{$this->unique}_save", $new_instance, $this->args, $this );

do_action( "csf_{$this->unique}_save_before", $new_instance, $this->args, $this );

return $new_instance;

}
}
}
