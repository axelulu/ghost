<?php 
$theme_ = get_template_directory();
if(!wp_is_mobile()){
require($theme_ . '/page/pc_index.php');
}else{
require($theme_ . '/page/mobile_index.php');	
}