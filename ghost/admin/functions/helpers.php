<?php if ( ! defined( 'ABSPATH' ) ) { die; }




if ( ! function_exists( 'csf_get_var' ) ) {
function csf_get_var( $var, $default = '' ) {

if( isset( $_POST[$var] ) ) {
return $_POST[$var];
}

if( isset( $_GET[$var] ) ) {
return $_GET[$var];
}

return $default;

}
}



if ( ! function_exists( 'csf_get_vars' ) ) {
function csf_get_vars( $var, $depth, $default = '' ) {

if( isset( $_POST[$var][$depth] ) ) {
return $_POST[$var][$depth];
}

if( isset( $_GET[$var][$depth] ) ) {
return $_GET[$var][$depth];
}

return $default;

}
}



if ( ! function_exists( 'csf_wp_editor_api' ) ) {
function csf_wp_editor_api() {

global $wp_version;

return version_compare( $wp_version, '4.8', '>=' );

}
}
