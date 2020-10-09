<?php 
//后台设置
require( '../../../../wp-load.php' );
$user_id=$current_user->ID;
if(!current_user_can('level_10')){exit();}

if(isset($_POST['post_id']) && isset($_POST['user_id'])){
$post_id=$_POST['post_id'];
$user_id=$_POST['user_id'];
if($post_id){
$wpdb->query( "DELETE FROM `" . $wpdb->prefix . "ghost_report` WHERE `post_id` = '$post_id'" );
sendMail(get_userdata($user_id)->user_email, '链接失效', '文章'.'<a href="'.get_permalink($post_id).'" rel="bookmark">'.get_the_title($post_id).'</a>'.'链接已经更新！');
$data_arr['code']=1;
$data_arr['msg']='删除成功！';
}else{
$data_arr['code']=0;
$data_arr['msg']='删除失败！';
}

}

header('content-type:application/json');
echo json_encode($data_arr);