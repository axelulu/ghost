<?php if ( ! defined( 'ABSPATH' ) ) { die; }
if( ! class_exists( 'GHOST_Field_code_editor' ) ) {
class GHOST_Field_code_editor extends GHOST_Fields {

public $version = '5.41.0';
public $cdn_url = 'https://cdn.jsdelivr.net/npm/codemirror@';

public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
parent::__construct( $field, $value, $unique, $where, $parent );
}

public function render() {

$default_settings = array(
'tabSize'       => 2,
'lineNumbers'   => true,
'theme'         => 'default',
'mode'          => 'htmlmixed',
'cdnURL'        => $this->cdn_url . $this->version,
);

$settings = ( ! empty( $this->field['settings'] ) ) ? $this->field['settings'] : array();
$settings = wp_parse_args( $settings, $default_settings );
$encoded  = htmlspecialchars( json_encode( $settings ) );

echo $this->field_before();
echo '<textarea name="'. $this->field_name() .'"'. $this->field_attributes() .' data-editor="'. $encoded .'">'. htmlspecialchars($this->value) .'</textarea>';
echo $this->field_after();

}

public function enqueue() {

if( ! wp_script_is( 'ghost-panel-codemirror' ) ) {
wp_enqueue_script( 'ghost-panel-codemirror', $this->cdn_url . $this->version .'/lib/codemirror.min.js', array( 'csf' ), $this->version, true );
wp_enqueue_script( 'ghost-panel-codemirror-loadmode', $this->cdn_url . $this->version .'/addon/mode/loadmode.min.js', array( 'ghost-panel-codemirror' ), $this->version, true );
}

if( ! wp_style_is( 'ghost-panel-codemirror' ) ) {
wp_enqueue_style( 'ghost-panel-codemirror', $this->cdn_url . $this->version .'/lib/codemirror.min.css', array(), $this->version );
}

}

}
}
