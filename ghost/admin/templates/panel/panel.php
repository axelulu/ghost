<?php 
if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
if( ! class_exists( 'GHOST_Field_panel' ) ) {
class GHOST_Field_panel extends GHOST_Fields {

public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
parent::__construct( $field, $value, $unique, $where, $parent );
}

public function render() {
	global $wpdb;
$Administrator_query = new WP_User_Query( array ( 
	'role'=>'Administrator'
));
$visitor_query = new WP_User_Query( array ( 
	'role'=>'visitor'
));
$vip_query = new WP_User_Query( array ( 
	'role'=>'vip'
));
$svip_query = new WP_User_Query( array ( 
	'role'=>'svip'
));
	$visitor_users = $visitor_query->get_total();
	$vip_users = $vip_query->get_total();
	$svip_users = $svip_query->get_total();
	$Administrator = $Administrator_query->get_total();
		
function get_report_type($types){
	if($types=='pwd'){
		return '提取密码无效';
	}else if($types=='pwd2'){
		return '解压密码无效';
	}else if($types=='container'){
		return '内容不符';
	}else if($types=='link'){
		return '链接失效';
	}
}

// 	报告
	$request = "SELECT type,user_id,post_id,container,msg_time FROM wp_ghost_report ORDER by msg_time";
	$requests = $wpdb->get_results($request);
	$report='';
	$report.='<div style="margin: 20px 0px"><h3 style="margin-left: 20px;">文章报告记录：</h3><table class="table-list"><tbody>';
	foreach ( $requests as $item_request ) {
			if($item_request->type == 'other'){
				$report.= '<tr><td style="padding: 10px;width: 20%;"><a target="_blank" href="'.ghost_get_user_author_link($item_request->user_id).'" title="'.get_userdata($item_request->user_id)->nickname.'">用户：'.get_userdata($item_request->user_id)->nickname.'</a></td><td style="padding: 10px;width: 30%;"><a target="_blank" href="'.get_permalink($item_request->post_id).'">'.get_post($item_request->post_id)->post_title.'</a></td><td style="padding: 10px;width: 20%;"><span>原因：其他</span></td><td style="padding: 10px;width: 25%;"><span>内容：'.$item_request->container.'</span></td><td style="padding: 10px;width: 200px;"><span>时间：'.$item_request->msg_time.'</span></td><td style="padding: 10px;width: 5%;"><span data-id="'.$item_request->post_id.'" data-userid="'.$item_request->user_id.'" class="report_del_btn">删除</span></td></tr>';
			}else{
				$report.= '<tr><td style="padding: 10px;width: 20%;"><a target="_blank" href="'.ghost_get_user_author_link($item_request->user_id).'" title="'.get_userdata($item_request->user_id)->nickname.'">用户：'.get_userdata($item_request->user_id)->nickname.'</a></td><td style="padding: 10px;width: 30%;"><a target="_blank" href="'.get_permalink($item_request->post_id).'">'.get_post($item_request->post_id)->post_title.'</a></td><td style="padding: 10px;width: 25%;"><span>原因：'.get_report_type($item_request->type).'</span></td><td style="padding: 10px;width: 20%;"><span>时间：'.$item_request->msg_time.'</span></td><td style="padding: 10px;width: 5%;"><span data-userid="'.$item_request->user_id.'" data-id="'.$item_request->post_id.'" class="report_del_btn">删除</span></td></tr>';
			}
			
	}
	$report.='</tbody></table></div>';
	
// 	今日文章访问人数
	$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
	$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
	$msg_time=strtotime(current_time('mysql'));
	$post_views = "SELECT type,user_id,post_id,ip,msg_time FROM wp_ghost_ip WHERE type='post' AND unix_timestamp(msg_time) > '$beginToday' && unix_timestamp(msg_time) < '$endToday' ORDER by msg_time DESC";
	$post_views = count($wpdb->get_results($post_views));
	
// 	今日用户访问人数
	$user_views = "SELECT type,user_id,post_id,ip,msg_time FROM wp_ghost_ip WHERE type='user_visit' AND unix_timestamp(msg_time) > '$beginToday' && unix_timestamp(msg_time) < '$endToday' ORDER by msg_time DESC";
	$user_views = count($wpdb->get_results($user_views));

// 	今日用户签到人数
	$today_sign_query = new WP_User_Query( array ( 
		'meta_key' => 'sign_daily',
		'meta_value' =>$beginToday,
		'meta_compare'=>'>=',
	));
	
// 	积分购买链接数量
	$request = "SELECT user_id,msg_type,msg_credit,msg_time,post_id FROM wp_ghost_msg WHERE msg_type='buy_download_link' ";
	$num = $wpdb->get_results($request);
	
// 	文章访问明细
	$request = "SELECT type,user_id,post_id,ip,msg_time FROM wp_ghost_ip WHERE type='post' AND user_id!=0 ORDER by msg_time DESC limit 0,20";
	$ips = $wpdb->get_results($request);
	$html='<div style="margin: 20px 0px" class="clear">';
	$html.='<div style="width: 48%;float:left"><h3 style="margin-left: 20px;">文章访问明细：</h3><table class="table-list"><tbody>';
	foreach ( $ips as $ip ) {
			if($ip->user_id){$user = get_userdata($ip->user_id)->nickname;}else{$user = '游客';}
			$html.= '<tr><td style="padding: 10px;width: 150px;"><a target="_blank" href="'.ghost_get_user_author_link($ip->user_id).'" title="'.$ip->ip.'">用户：'.$user.'</a></td><td style="padding: 10px;width: 400px;"><a target="_blank" href="'.get_permalink($ip->post_id).'">'.get_post($ip->post_id)->post_title.'</a></td><td style="padding: 10px;width: 200px;"><span>时间：'.$ip->msg_time.'</span></td></tr>';
	}
	$html.='</tbody></table></div>';
	
// 	用户在线明细
	$online_user='';
	$request2 = "SELECT type,user_id,post_id,ip,msg_time FROM wp_ghost_ip WHERE type='user_visit' AND user_id!=0 ORDER by msg_time DESC limit 0,20";
	$userips = $wpdb->get_results($request2);
	$online_user.='<div style="width: 48%;float:right"><h3 style="margin-left: 20px;">用户在线明细：</h3><table class="table-list right"><tbody>';
foreach ( $userips as $ip ) {
			if($ip->user_id){$user = get_userdata($ip->user_id)->nickname;}else{$user = '游客';}
			$online_user.= '<tr><td style="padding: 10px;width: 150px;"><a target="_blank" href="'.ghost_get_user_author_link($ip->user_id).'" title="'.$ip->ip.'">用户：'.$user.'</a></td><td style="padding: 10px;width: 200px;"><span>ip：'.$ip->ip.'</span></td><td style="padding: 10px;width: 200px;"><span>时间：'.$ip->msg_time.'</span></td></tr>';
	}
	$online_user.='</tbody></table></div></div>';
?>

<div class="ghost-admin-panel-box clear">
<li class="opacity">
<a href="/wp-admin/users.php?role=administrator" target="_blank">
<div class="icon"><i class="ghost-icon ghost-renzheng"></i></div>
<div class="info">
<p><span><?php echo $Administrator;?></span><?php _e('人','ghost');?></p>
<p><?php _e('管理员用户','ghost');?></p>
</div>
</a>
</li>
	
<li class="opacity">
<a href="/wp-admin/users.php?role=visitor" target="_blank">
<div class="icon"><i class="ghost-icon ghost-renzheng"></i></div>
<div class="info">
<p><span><?php echo $visitor_users;?></span><?php _e('人','ghost');?></p>
<p><?php _e('游客用户','ghost');?></p>
</div>
</a>
</li>

<li class="opacity">
<a href="/wp-admin/users.php?role=vip" target="_blank">
<div class="icon"><i class="ghost-icon ghost-heimingdan1"></i></div>
<div class="info">
<p><span><?php echo $vip_users;?></span><?php _e('人','ghost');?></p>
<p><?php _e('会员用户','ghost');?></p>
</div>
</a>
</li>

<li class="opacity">
<a href="/wp-admin/users.php?role=svip" target="_blank">
<div class="icon"><i class="ghost-icon ghost-heimingdan"></i></div>
<div class="info">
<p><span><?php echo $svip_users;?></span><?php _e('人','ghost');?></p>
<p><?php _e('大会员用户','ghost');?></p>
</div>
</a>
</li>

<li class="opacity">
<a target="_blank">
<div class="icon"><i class="ghost-icon ghost-heimingdan"></i></div>
<div class="info">
<p><span><?php echo $post_views;?></span><?php _e('人','ghost');?></p>
<p><?php _e('今日文章访问人数','ghost');?></p>
</div>
</a>
</li>

<li class="opacity">
<a target="_blank">
<div class="icon"><i class="ghost-icon ghost-heimingdan"></i></div>
<div class="info">
<p><span><?php echo $user_views;?></span><?php _e('人','ghost');?></p>
<p><?php _e('今日用户访问人数','ghost');?></p>
</div>
</a>
</li>

<li class="opacity">
<a target="_blank">
<div class="icon"><i class="ghost-icon ghost-heimingdan"></i></div>
<div class="info">
<p><span><?php echo $today_sign_query->get_total();?></span><?php _e('人','ghost');?></p>
<p><?php _e('今日用户签到人数','ghost');?></p>
</div>
</a>
</li>


<li class="opacity">
<a target="_blank">
<div class="icon"><i class="ghost-icon ghost-heimingdan"></i></div>
<div class="info">
<p><span><?php echo count($num);?></span><?php _e('个','ghost');?></p>
<p><?php _e('积分购买链接数量','ghost');?></p>
</div>
</a>
</li>

</div>
<?php echo $report.$html.$online_user; }
}
}