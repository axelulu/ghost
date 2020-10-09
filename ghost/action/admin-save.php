<?php 
//后台设置
require( '../../../../wp-load.php' );
$user_id=$current_user->ID;
if(!current_user_can('level_10')){exit();}

if(isset($_POST['data'])){
$setting=$_POST['data'];

$setting_arr=json_decode(stripslashes(trim($setting)),true);
if(is_array($setting_arr)){
$status=update_option('ghost_options',$setting_arr['ghost_options']);
$data_arr['code']=1;
$data_arr['msg']='保存成功！';
}else{
$data_arr['code']=0;
$data_arr['msg']='保存的数据格式有误！';
}

}

header('content-type:application/json');
echo json_encode($data_arr);