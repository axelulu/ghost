<?php
//定时任务
add_action('my_hourly_event', 'do_this_hourly');
function my_activation() {
	date_default_timezone_set('Asia/Shanghai');
	if (!wp_next_scheduled('wpjam_daily_function_hook')) {
		wp_schedule_event( time(), 'daily', 'wpjam_daily_function_hook' );
	}
}
add_action('wp', 'my_activation');
function do_this_daily() {
	global $wpdb;
	$wpdb->query( " DELETE FROM 'wp_usermeta' WHERE meta_key='daily_msg_num'" );
}
//定时任务

//获取下载链接数量
function ghost_get_post_shop_num($post_id) {
    if($post_id){
        global $wpdb;
			$request = "SELECT msg_type,post_id,status FROM wp_ghost_msg WHERE msg_type='buy_download_link' AND post_id='$post_id' ";
			$num = count($wpdb->get_results($request));
			return $num;
    }
}

// 获取文章视频图标
function get_video_post_icon($post_id){
	$video_urls=json_decode(get_post_meta($post_id,'ghost_video',true));
	if($video_urls){
		return '<i class="video_class fab fa-youtube"></i>';
	}
}
// 获取文章类型
function ghost_get_post_type($type){
	if($type=='music'){
		return 'ghost_music';
	}elseif($type=='video'){
		return 'ghost_video';
	}elseif($type=='words'){
		return 'ghost_words';
	}elseif($type=='focus'){
		return 'ghost_focus';
	}else{
		return '';
	}
}

//表情
function smilies_reset() {
	global $wpsmiliestrans;
	$emojis_url = 'https://img.catacg.cn/img/emojis/';
	if ( !get_option( 'use_smilies' ) )
	    return;
	    $wpsmiliestrans = array(
			'[滑稽]' => '<img class="pink-smilies" src="'.$emojis_url.'滑稽.jpg" />',
			'[感谢分享]' => '<img class="pink-smilies" src="'.$emojis_url.'感谢分享.jpg" />',
			'[脸红]' => '<img class="pink-smilies" src="'.$emojis_url.'脸红.gif" />',
			'[杯具]' => '<img class="pink-smilies" src="'.$emojis_url.'杯具.gif" />',
			'[亚历山大]' => '<img class="pink-smilies" src="'.$emojis_url.'亚历山大.gif" />',
			'[想要]' => '<img class="pink-smilies" src="'.$emojis_url.'想要.gif" />',
			'[吃惊]' => '<img class="pink-smilies" src="'.$emojis_url.'吃惊.jpg" />',
			'[好样的]' => '<img class="pink-smilies" src="'.$emojis_url.'好样的.gif" />',
			'[感谢分享2]' => '<img class="pink-smilies" src="'.$emojis_url.'感谢分享2.jpg" />',
			'[生气]' => '<img class="pink-smilies" src="'.$emojis_url.'生气.jpg" />',
			'[卖萌]' => '<img class="pink-smilies" src="'.$emojis_url.'卖萌.jpg" />',
			'[OK！]' => '<img class="pink-smilies" src="'.$emojis_url.'OK！.jpg" />',
			'[不行]' => '<img class="pink-smilies" src="'.$emojis_url.'不行.jpg" />',
			'[叹气]' => '<img class="pink-smilies" src="'.$emojis_url.'叹气.jpg" />',
			'[棒！]' => '<img class="pink-smilies" src="'.$emojis_url.'棒！.jpg" />',
			'[偷笑]' => '<img class="pink-smilies" src="'.$emojis_url.'偷笑.jpg" />',
			'[噫]' => '<img class="pink-smilies" src="'.$emojis_url.'噫.jpg" />',
			'[good]' => '<img class="pink-smilies" src="'.$emojis_url.'good.jpg" />',
			'[不明真相]' => '<img class="pink-smilies" src="'.$emojis_url.'不明真相.jpg" />',
			'[太棒了]' => '<img class="pink-smilies" src="'.$emojis_url.'太棒了.jpg" />',
			'[不知所措]' => '<img class="pink-smilies" src="'.$emojis_url.'不知所措.jpg" />',
			'[盯..]' => '<img class="pink-smilies" src="'.$emojis_url.'盯.jpg" />',
			'[所以呢]' => '<img class="pink-smilies" src="'.$emojis_url.'所以呢.jpg" />',
			'[残念]' => '<img class="pink-smilies" src="'.$emojis_url.'残念.jpg" />',
	    );
}
smilies_reset();

/**
 * 纯真 IP 数据库查询 
 * 
 * 参考资料：
 * - 纯真 IP 数据库 http://www.cz88.net/ip/
 * - PHP 读取纯真IP地址数据库 http://ju.outofmemory.cn/entry/42500
 * - 纯真 IP 数据库自动更新文件教程 https://www.22vd.com/40035.html
 * - IpLocation https://github.com/nauxliu/IpLocation/
 * - 基于本地数据库的 IP 地址查询 PHP 源码 https://mkblog.cn/?p=1951
 * 
 * 使用示例：
 *   $ip = new IPQuery();
 *   $addr = $ip->query('IP地址');
 *   print_r($addr);
 *///这个类似用来获取访客信息的
//方便统计
class visitorInfo
{
 //获取访客ip
 public function getIp()
 {
  $ip=false;
  if(!empty($_SERVER["HTTP_CLIENT_IP"])){
   $ip = $_SERVER["HTTP_CLIENT_IP"];
  }
  if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
   $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
   if ($ip) { array_unshift($ips, $ip); $ip = FALSE; }
   for ($i = 0; $i < count($ips); $i++) {
    if (!eregi ("^(10│172.16│192.168).", $ips[$i])) {
     $ip = $ips[$i];
     break;
    }
   }
  }
  return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
 }
 
 //根据ip获取城市、网络运营商等信息
 public function findCityByIp($ip){
  $data = file_get_contents('https://apis.map.qq.com/ws/location/v1/ip?ip='.$ip.'&key='.ghost_get_option('key_ip'));
  return json_decode($data,$assoc=true);
 }
 
 //获取用户浏览器类型
 public function getBrowser(){
  $agent=$_SERVER["HTTP_USER_AGENT"];
  if(strpos($agent,'MSIE')!==false || strpos($agent,'rv:11.0')) //ie11判断
   return "ie";
  else if(strpos($agent,'Firefox')!==false)
   return "firefox";
  else if(strpos($agent,'Chrome')!==false)
   return "chrome";
  else if(strpos($agent,'Opera')!==false)
   return 'opera';
  else if((strpos($agent,'Chrome')==false)&&strpos($agent,'Safari')!==false)
   return 'safari';
  else
   return 'unknown';
 }
 
 //获取网站来源
 public function getFromPage(){
  return $_SERVER['HTTP_REFERER'];
 }
 
}

// 商城
function ghost_shop_item_link_submit_credit($user_id){
    $user = new WP_User($user_id);
    $user_type = array_shift($user->roles);
    if( get_user_meta( $user_id, 'ghost_guajian', true )) {
        $user_type = 'ghost_shop_item_link_cut';
    }else{
        $user_type = 'ghost_shop_item_link_submit';
    }
    return $user_type;
}
function ghost_shop_item_link_submit_svip($user_id){
    $user = new WP_User($user_id);
    $user_type = array_shift($user->roles);
    if( $user_type == 'svip' || $user_type == 'administrator' ) {
        $user_type = 'ghost_shop_item_link_cut';
    }else{
        $user_type = 'ghost_shop_item_link_submit_svip';
    }
    return $user_type;
}
function ghost_shop_item_link_submit_vip($user_id){
    $user = new WP_User($user_id);
    $user_type = array_shift($user->roles);
    if( $user_type == 'vip' || $user_type == 'administrator' ) {
        $user_type = 'ghost_shop_item_link_cut';
    }else{
        $user_type = 'ghost_shop_item_link_submit_vip';
    }
    return $user_type;
}

function get_author_type($types,$type){
	if($types==$type){
		return 'is-active';
	}
}
// 短代码
function content_hide($atts, $content=null) {
	$deflink = empty(ghost_get_option('ghost_site_me_link')) ? 'me' : ghost_get_option('ghost_site_me_link');
	if( is_user_logged_in() && (current_user_can( 'svip' ) || current_user_can( 'vip' ) || current_user_can( 'manage_options' ) )) {
		return $content;
	}elseif(!is_user_logged_in()){
		return '<div class="ghost_download_content_btn">
					<div class="poi-btn-group">
						<a class="ghost_btn ghost_btn_success download user-login" rel="noreferrer" target="_blank">
							<span class="poi-icon fa-cloud-download-alt fas fa-fw" aria-hidden="true"></span>
							<span class="ghost_icon_text">登陆查看下载链接</span></a>
					</div>
				</div>';
	}else{
		return '<div class="ghost_download_content_btn">
					<div class="poi-btn-group">
						<a href="'.home_url('/'.$deflink.'/answer').'" class="ghost_btn ghost_btn_success download" rel="noreferrer" target="_blank">
							<span class="poi-icon fa-cloud-download-alt fas fa-fw" aria-hidden="true"></span>
							<span class="ghost_icon_text">答题成为正式会员即可查看下载链接</span></a>
					</div>
				</div>';
	}
}
add_shortcode('content_hide', 'content_hide');
//自定义评论列表模板
function simple_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; 
	global $current_user,$wpdb;
	$user_id = $current_user->ID;
	$user_like = $wpdb->query( "SELECT comment_id,user_id FROM wp_ghost_comment_like WHERE comment_id=$comment->comment_ID AND user_id=$user_id" );?>
	<section id="comment-<?php comment_ID(); ?>" class="ghost_comment_item_container">
		<div class="ghost_comment_item">
			<div class="ghost_comment_item_avatar">
					<a href="<?php echo ghost_get_user_author_link($comment->user_id); ?>" class="inn-comment__item__avatar__link" title="<?php echo get_user_meta($comment->user_id,'nickname',true) ?>">
					<?php if(get_user_meta($comment->user_id,'ghost_guajian',true)){ ?>
					<img src="<?php echo get_user_meta($comment->user_id,'ghost_guajian',true) ?>" alt="" class="ghost_comment_guajian">
					<?php } ?>
					<img style="padding: 8px;width: 50px;border-radius:50%;height: 50px;" alt="" src="<?php echo get_user_meta($comment->user_id,'ghost_user_avatar',true) ?>" class="avatar avatar-50 photo" height="50" width="50"></a>
			</div>
			<div class="ghost_comment_item_body">
				<header class="ghost_comment_item_header">
					<div class="ghost_comment_header_text">
						<div class="ghost_comment_item_meta_container">
							<a href="<?php echo ghost_get_user_author_link($comment->user_id); ?>" class="ghost_comment_item_author_link"><?php echo get_user_meta($comment->user_id,'nickname',true) ?></a>
							<span class="ghost_comment_item_label_role" style="background-color: rgb(225, 179, 42);"><?php echo ghost_user_type($comment->user_id); ?></span></div>
						<div class="ghost_comment_item_author_container">
							<span class="ghost_comment_item_time"><?php echo ghost_date($comment->comment_date) ?></span></div>
					</div>
					<div class="ghost_comment_item_header_tool_container">
						<?php if($user_like){?>
							<a data-commentid="<?php echo $comment->comment_ID ?>" class="user_like poi-tooltip is-top ghost_comment_item_like_btn <?php echo get_my_login_type('ghost_like_active'); ?>" title="赞">
								<span class="ghost_comment_item_like_btn_icon poi-icon fa-thumbs-up fas fa-fw" aria-hidden="true"></span>
								<span><?php echo get_comment_meta($comment->comment_ID,'comments_like',true); ?></span>
							</a>
						<?php }else{ ?>
							<a data-commentid="<?php echo $comment->comment_ID ?>" class="poi-tooltip is-top ghost_comment_item_like_btn <?php echo get_my_login_type('ghost_like_active'); ?>" title="赞">
								<span class="ghost_comment_item_like_btn_icon poi-icon fa-thumbs-up far fa-fw" aria-hidden="true"></span>
								<span><?php echo get_comment_meta($comment->comment_ID,'comments_like',true); ?></span>
							</a>
						<?php } ?>
						<a data-commentid="<?php echo $comment->comment_ID ?>" class="ghost_comment_item_reply_btn <?php echo get_my_login_type('ghost_reply_active'); ?>">回复</a>
					</div>
				</header>
				<div class="ghost_comment_item_content">
					<div class="ghost_comment_item_content_text"><?php echo convert_smilies($comment->comment_content) ?></div></div>
			</div>
		</div>
<?php
}

function ghost_comment_callback_close() {
    echo '</section>';
}

function online_user(){
	global $wpdb;
	$maplers=0;
	$msg_time=current_time('mysql');
	$user_visit_strtotime = ghost_get_option('user_visit_strtotime') ? ghost_get_option('user_visit_strtotime') : 30;
	$request2 = "SELECT type,user_id,post_id,ip,msg_time FROM wp_ghost_ip WHERE type='user_visit' AND user_id!=0 ORDER by msg_time DESC";
	$userips = $wpdb->get_results($request2);
	foreach ( $userips as $ip ) {
		if(strtotime($msg_time)-strtotime($ip->msg_time)<$user_visit_strtotime){
			$maplers++;
		}
	}
	return "当前在线用户：".$maplers."人";
}

// 未登录显示登陆的class
function get_my_login_type($type=''){
    if(is_user_logged_in()){
        return $type;
    }else{
        return 'user-login';
    }
}

/* 检查百度是否已收录文章页面 开始*/
function baidu_check($url) {
$url = 'http://www.baidu.com/s?wd=' . urlencode($url);
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$rs = curl_exec($curl);
curl_close($curl);
if (!strpos($rs, '没有找到')) { //没有找到说明已被百度收录
return 1;
} else {
return -1;
}
}
function baidu_record($url) {if(baidu_check($url) == 1) {echo '<a target="_blank" title="点击查看" rel="external nofollow" href="https://www.baidu.com/s?wd='.get_the_title().'">百度已收录</a>';
} else {echo '<a style="color:red;" rel="external nofollow" title="一键帮忙提交给百度，谢谢您！" target="_blank" href="https://zhanzhang.baidu.com/sitesubmit/index?sitename='.get_permalink().'">百度未收录</a>';
}
}

// 获取粉丝数量
function ghost_get_flower_num($user_id){
    global $wpdb;
    $request = "SELECT fans_id,user_id FROM wp_ghost_fans WHERE fans_id=$user_id";
    $flower = $wpdb->get_results($request);
    return count($flower);
}

function ghost_get_fans_num($user_id){
    global $wpdb;
    $request = "SELECT fans_id FROM wp_ghost_fans WHERE user_id=$user_id";
    $fan = $wpdb->get_results($request);
    return count($fan);
}

// 判断用户级别
function ghost_user_type($user_id){
    $user = new WP_User($user_id);
    $user_type = array_shift($user->roles);
    if( $user_type == 'visitor' ) {
        $user_type = '游客';
    }elseif( $user_type == 'vip' ){
        $user_type = '正式会员';
    }elseif( $user_type == 'svip' ){
        $user_type = '大会员';
    }elseif( $user_type == 'administrator' ){
        $user_type = '超级管理员';
    }
    return $user_type;
}

//获取顶级分类ID
function salong_category_top_parent_id ($current_cat_ID) {
    while ($current_cat_ID) {
        $cat = get_category($current_cat_ID); // 得到分类
        $current_cat_ID = $cat->category_parent; // 当前分类的父分类
        $catParent = $cat->cat_ID;
    }
    return $catParent;
}

//根据文章id获取父级论坛id
function ghost_get_post_cat_id($post_id){
  $category_a = get_the_category($post_id);
  $category=get_category($category_a[0]->term_id);
  $cat_parents=$category->parent;
  if($cat_parents==0){//如果不存在父级则输出当前论坛id
  return $category_a[0]->term_id;
  }else{
  return $cat_parents;  
  } 
}

//时间 timeago

function ghost_time_ago($post_id = 0) {
	$time_string = '<time class="timeago" datetime="%1$s" data-timeago="%2$s" ref="timeAgo">%2$s</time>';

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ,$post_id) ),
		esc_html( get_the_date('Y-n-j G:i:s',$post_id) )
	);

    return $time_string;
}

//获取文章封面
function catch_that_image() {
    global $post;
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img*.+src=[\'"]([^\'"]+)[\'"].*>/iU', wp_unslash($post->post_content), $matches);
    if(empty($output)){
        $first_img = ghost_get_option('post_lazy_img');
    }else {
        if(ghost_get_option('ghost_thumbnail')){
            $first_img = $matches [1][0].ghost_get_option('ghost_thumbnail');
        }else{
            $first_img = $matches [1][0];
        }
    }
    return $first_img;
}

//过滤蜘蛛地址
function isCrawler() { 
	$spiderSite= array( 
					"TencentTraveler", 
					"Baiduspider+", 
					"BaiduGame", 
					"Googlebot", 
					"msnbot", 
					"Sosospider+", 
					"Sogou web spider", 
					"ia_archiver", 
					"Yahoo! Slurp", 
					"YoudaoBot", 
					"Yahoo Slurp", 
					"MSNBot", 
					"Java (Often spam bot)", 
					"BaiDuSpider", 
					"Voila", 
					"Yandex bot", 
					"BSpider", 
					"twiceler", 
					"Sogou Spider", 
					"Speedy Spider", 
					"Google AdSense", 
					"Heritrix", 
					"Python-urllib", 
					"Alexa (IA Archiver)", 
					"Ask", 
					"Exabot", 
					"Custo", 
					"OutfoxBot/YodaoBot", 
					"yacy", 
					"SurveyBot", 
					"legs", 
					"lwp-trivial", 
					"Nutch", 
					"StackRambler", 
					"The web archive (IA Archiver)", 
					"Perl tool", 
					"MJ12bot", 
					"Netcraft", 
					"MSIECrawler", 
					"WGet tools", 
					"larbin", 
					"Fish search", 
			); 
	if(in_array(strtolower($_SERVER['HTTP_USER_AGENT']),$spiderSite)){ 
		return true; 
	}else{ 
		return false; 
	} 
	}
// 获取ip
function getClientIp()
{
	if (isset($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]))
	{
		$ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
	}
	elseif (isset($HTTP_SERVER_VARS["HTTP_CLIENT_IP"]))
	{
		$ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];
	}
	elseif (isset($HTTP_SERVER_VARS["REMOTE_ADDR"]))
	{
		$ip = $HTTP_SERVER_VARS["REMOTE_ADDR"];
	}
	elseif (getenv("HTTP_X_FORWARDED_FOR"))
	{
		$ip = getenv("HTTP_X_FORWARDED_FOR");
	}
	elseif (getenv("HTTP_CLIENT_IP"))
	{
		$ip = getenv("HTTP_CLIENT_IP");
	}
	elseif (getenv("REMOTE_ADDR"))
	{
		$ip = getenv("REMOTE_ADDR");
	}
	else
	{
		$ip = "Unknown";
	}
	$ban_range_low=ip2long("46.229.168.0"); //ip段首 
	$ban_range_up=ip2long("46.229.168.255");//ip段尾 
	$ban_range_low2=ip2long("204.000.000.000"); //ip段首 
	$ban_range_up2=ip2long("209.255.255.255");//ip段尾 
	$ban_range_low3=ip2long("216.000.000.000"); //ip段首 
	$ban_range_up3=ip2long("216.255.255.255");//ip段尾 
	$ban_range_low4=ip2long("214.000.000.000"); //ip段首 
	$ban_range_up4=ip2long("215.255.255.255");//ip段尾 
	$ban_range_low5=ip2long("224.000.000.000"); //ip段首 
	$ban_range_up5=ip2long("224.255.255.255");//ip段尾 
	$ban_range_low6=ip2long("40.77.167.000"); //ip段首 
	$ban_range_up6=ip2long("40.77.167.255");//ip段尾 
	$ban_range_low7=ip2long("46.229.168.000"); //ip段首 
	$ban_range_up7=ip2long("46.229.168.255");//ip段尾 
	$ips=ip2long($ip); 
	if ($ips>$ban_range_low && $ips<$ban_range_up && $ips>$ban_range_low2 && $ips<$ban_range_up2 && $ips>$ban_range_low3 && $ips<$ban_range_up3 && $ips>$ban_range_low4 && $ips<$ban_range_up4 && $ips>$ban_range_low5 && $ips<$ban_range_up5 && $ips>$ban_range_low6 && $ips<$ban_range_up6 && $ips>$ban_range_low7 && $ips<$ban_range_up7) 
	{ 
		$ip = "Unknown";
	} 

	return $ip;
}

// 验证ip
function isIp($ip) {
   if (preg_match('/^((?:(?:25[0-5]|2[0-4]\d|((1\d{2})|([1-9]?\d)))\.){3}(?:25[0-5]|2[0-4]\d|((1\d{2})|([1 -9]?\d))))$/', $ip) && !isCrawler()) {
	   return 1;
   } else {
	   return 0;
   }
}

//添加点击次数字段
function record_visitors()   
{   
	//浏览文章
    if (is_singular())
    {   
		global $post,$wpdb,$current_user;
		if($current_user->ID){
			$uid = $current_user->ID;
		}else{
			$uid = 0;
		}
		$table_name=$wpdb->prefix.'ghost_ip';
		$post_ID = $post->ID;
		$msg_time=current_time('mysql');
		// IP地址合法验证, 防止通过IP注入攻击
		if(isIp(getClientIp()) ){
			$ip = getClientIp();
			$user_visit_strtotime = ghost_get_option('user_visit_strtotime') ? ghost_get_option('user_visit_strtotime') : 30;
			$query_ip = $wpdb->query("SELECT type,user_id,ip,post_id FROM wp_ghost_ip WHERE type='post' AND post_id='$post_ID' AND ip='$ip'");
			$query_time = $wpdb->get_row("SELECT type,user_id,ip,post_id,msg_time FROM wp_ghost_ip WHERE type='post' AND ip='$ip' AND post_id='$post_ID'");
			if(strtotime($msg_time)-strtotime($query_time->msg_time)>$user_visit_strtotime && $uid!=0){
				if(!$query_ip){
					$wpdb->query( "INSERT INTO $table_name (type,user_id,post_id,ip,msg_time) VALUES ('post','$uid','$post_ID','$ip','$msg_time')" );
				}else{
					$wpdb->update('wp_ghost_ip' , array( 'msg_time' => $msg_time ), array( 'ip' => $ip, 'type'=>'post','post_id' => $post_ID ) );
				}
			}
		}else{
			$ip = '不合法';
		}
    }
}   
add_action('wp_head', 'record_visitors');

//记录用户访问明细
function user_visits(){
		global $post,$wpdb,$current_user;
		if($current_user->ID){
			$uid = $current_user->ID;
		}else{
			$uid = 0;
		}
		// IP地址合法验证, 防止通过IP注入攻击
		if(isIp(getClientIp())){
			$ip = getClientIp();
		}else{
			$ip = '不合法';
		}
		$user_visit_strtotime = ghost_get_option('user_visit_strtotime') ? ghost_get_option('user_visit_strtotime') : 30;
		$table_name=$wpdb->prefix.'ghost_ip';
		$msg_time=current_time('mysql');
		$query_time = $wpdb->get_row("SELECT type,user_id,ip,post_id,msg_time FROM wp_ghost_ip WHERE type='user_visit' AND ip='$ip'");
		if(strtotime($msg_time)-strtotime($query_time->msg_time)>$user_visit_strtotime && $uid!=0){
			$query_ip = $wpdb->query("SELECT type,user_id,ip,post_id FROM wp_ghost_ip WHERE type='user_visit' AND ip='$ip'");
			if(!$query_ip){
				$wpdb->query( "INSERT INTO $table_name (type,user_id,post_id,ip,msg_time) VALUES ('user_visit','$uid','0','$ip','$msg_time')" );
			}else{
				$query_ip = $wpdb->update('wp_ghost_ip' , array( 'msg_time' => $msg_time ), array( 'ip' => $ip, 'type'=>'user_visit' ) );
			}
		}
}
add_action('wp_head', 'user_visits');

//获取点击次数
function get_post_views()
{   
	global $post,$wpdb;   
	$post_ID = $post->ID;
	$request = "SELECT type,user_id,post_id,ip FROM wp_ghost_ip WHERE type='post' AND post_id=$post_ID";
	$query = $wpdb->get_results($request);
	if($query){
		$views = count($query);
		update_post_meta($post_ID, 'ghost_views', $views);
	}else{
	  $views = 0;
	}
  if ($views >= 1000) {
      $views = round($views / 1000, 2) . 'K';
  }
  return $views;
}  
 
// AJAX登录验证
function ghost_ajax_login(){
	$result	= array();
	if(isset($_POST['user']['user_security']) && wp_verify_nonce( $_POST['user']['user_security'], 'userlogin_security_nonce' ) ){
		$creds = array();
		$creds['user_login'] = trim(htmlspecialchars($_POST['user']['email']));
		$creds['user_password'] = trim(htmlspecialchars($_POST['user']['pwd']));
		$creds['remember'] = ( isset( $_POST['user']['remember'] ) ) ? $_POST['user']['remember'] : false;
		$login = wp_signon($creds, true);
		$login_email_msg = get_user_meta($login->ID,'login_email_msg',true);
		$login_email_msg = isset($login_email_msg) ? $login_email_msg : ghost_get_option('login_email_msg');
		if ( ! is_wp_error( $login ) ){
            if($login_email_msg){
                sendMail($_POST['user']['email'], '登录账户', '登录成功');
            }
			$result['code']	= 1;
			$result['message']	= '登录成功';
		}else{
			$result['code']	= 0;
			$result['message']	= ( $login->errors ) ? strip_tags( $login->get_error_message() ) : '<strong>ERROR</strong>: ' . esc_html__( '账户错误', 'ghost' );
		}
	}else{
		$result['code']	= 0;
		$result['message'] = __('安全认证失败','ghost');
	}
	header( 'content-type: application/json; charset=utf-8' );
	echo json_encode( $result );
	exit;
 
}
add_action( 'wp_ajax_ajaxlogin', 'ghost_ajax_login' );
add_action( 'wp_ajax_nopriv_ajaxlogin', 'ghost_ajax_login' );

// 更新用户积分
// reg  注册信息提醒
// forget  忘记密码提醒
// avatar  更改头像提醒
// myemail  修改邮箱提醒
// pwd  修改密码提醒
// postcomment  提交文章评论提醒
// usercomment  提交用户评论提醒
// post  发布文章提醒
// sign_daily 每日签到
// guajian 修改挂件
function ghost_update_user_credit($user_id,$num,$type=null,$post_id=null,$commentid=null,$flower_id=null,$fans_id=null,$target_id=null){
    if($mycredit = get_user_meta($user_id,'user_credit',true)){
        update_user_meta($user_id,'user_credit',$num+$mycredit);
    }else{
        update_user_meta($user_id,'user_credit',ghost_get_option('user_reg_credit'));
    }
    if($type){
        global $wpdb;
        $table_name=$wpdb->prefix.'ghost_msg';
        $time=current_time('mysql');
        $wpdb->query( "INSERT INTO $table_name (user_id,target_id,msg_type,msg_credit,msg_time,post_id,commentid,flower_id,fans_id,status) VALUES ('$user_id','$target_id','$type','$num','$time','$post_id','$commentid','$flower_id','$fans_id',0)" );
    }
    return get_user_meta($user_id,'user_credit',true);
}

// AJAX注册验证
function ghost_ajax_register(){
	$result	= array();
    session_start();
	if(isset($_POST['user']['user_security']) && wp_verify_nonce( $_POST['user']['user_security'], 'userreg_security_nonce' ) ){
		$user_login = sanitize_user($_POST['user']['username']);
        $user_pass = trim(htmlspecialchars($_POST['user']['pwd']));
        $veriCode = (int)$_POST['user']['veriCode'];
		$user_email	= apply_filters( 'user_registration_email', $_POST['user']['email'] );
		$errors	= new WP_Error();
		if( ! validate_username( $user_login ) ){
			$errors->add( 'invalid_username', '用户名错误' );
		}elseif(username_exists( $user_login )){
			$errors->add( 'username_exists', '用户名已注册' );
		}elseif(email_exists( $user_email )){
			$errors->add( 'email_exists', '邮箱已注册' );
		}
		do_action( 'register_post', $user_login, $user_email, $errors );
		$errors = apply_filters( 'registration_errors', $errors, $user_login, $user_email );
		if ( $errors->get_error_code() ){
			$result['code']	= 0;
			$result['message'] 	= $errors->get_error_message();
		} else {
            if($_SESSION['ghost_verify_email']==$user_email && $_SESSION['ghost_verify_code']==$veriCode){
                $user_id = wp_create_user( $user_login, $user_pass, $user_email );//创建用户
                if(!$user_id){
                    $errors->add( 'registerfail', sprintf( '无法注册', get_option( 'admin_email' ) ) );
                    $result['code']	= 0;
                    $result['message'] 	= $errors->get_error_message();
                }
                update_user_option( $user_id, 'user_passwd', $user_pass, true ); //设置用户密码
                //给注册用户赋予角色
                wp_update_user(
                    array(
                        'ID'       => $user_id,
                        'role'    => 'visitor'
                    )
                );
                // 更新用户头像
                update_user_meta($user_id, 'ghost_user_avatar', ghost_get_option('user_avatar'));
                // 设置积分与发送邮件
                wp_new_user_notification( $user_id, $user_pass );
                $credit = ghost_update_user_credit($user_id,ghost_get_option('user_reg_credit'),'reg');
                if(ghost_get_option('reg_email_msg')){
                    sendMail($user_email, '注册账户', '注册成功！注册奖励积分：'.ghost_get_option('user_reg_credit').'剩余积分数'.$credit);
                }
                $result['code']	= 1;
                $result['message']	= '注册成功';
                //自动登录
                wp_set_current_user($user_id);
                wp_set_auth_cookie($user_id);
            }else{
                $result['code']	= 2;
                $result['message']	= '验证码错误'.$_SESSION['ghost_verify_code'].$_SESSION['ghost_verify_email'];
            }
        }
 	
	}else{
		$result['message'] = '安全认证失败';
	}
	header( 'content-type: application/json; charset=utf-8' );
	echo json_encode( $result );
	exit;	
}
add_action( 'wp_ajax_ajaxregister', 'ghost_ajax_register' );
add_action( 'wp_ajax_nopriv_ajaxregister', 'ghost_ajax_register' );

// AJAX忘记密码验证
function ajaxforget(){
	$result	= array();
    session_start();
	if(isset($_POST['user']['user_security']) && wp_verify_nonce( $_POST['user']['user_security'], 'userforget_security_nonce' ) ){
        $user_pass = trim(htmlspecialchars($_POST['user']['pwd']));
        $veriCode = (int)$_POST['user']['veriCode'];
			$user_email	= trim(htmlspecialchars($_POST['user']['email']));
        $errors	= new WP_Error();
        if(!email_exists( $user_email )){
			$errors->add( 'email_exists', '邮箱已被注册' );
		}
        if($_SESSION['ghost_verify_email']==$user_email && $_SESSION['ghost_verify_code']==$veriCode){
            $user_id = get_user_by( 'email', $user_email );
            wp_set_password( $user_pass, $user_id->ID );
            $credit = ghost_update_user_credit($user_id->ID,ghost_get_option('user_forget_credit'),'forget');
					$forget_email_msg = get_user_meta($user_id->ID,'forget_email_msg',true);
				$forget_email_msg = isset($forget_email_msg) ? $forget_email_msg : ghost_get_option('forget_email_msg');
            if($forget_email_msg){
                sendMail($user_email, '忘记密码', '密码修改成功！');
            }
            $result['code']	= 1;
            $result['message']	= '修改成功';
            //自动登录
            wp_set_current_user($user_id->ID);
            wp_set_auth_cookie($user_id->ID);
        }else{
            $result['code']	= 2;
            $result['message']	= '验证码错误';
        }
 	
	}else{
        $result['code']	= 0;
		$result['message'] = '安全认证失败';
	}
	header( 'content-type: application/json; charset=utf-8' );
	echo json_encode( $result );
	exit;	
}
add_action( 'wp_ajax_ajaxforget', 'ajaxforget' );
add_action( 'wp_ajax_nopriv_ajaxforget', 'ajaxforget' );

//邮件发送函数
function mail_smtp($phpmailer){
    $phpmailer->IsSMTP();
    $phpmailer->isHTML(true);
    $phpmailer->Mailer = "smtp";
    $phpmailer->SMTPAuth = ghost_get_option('SMTPAuth'); //SMTP认证（true/flase）
    $phpmailer->FromName = ghost_get_option('FromName'); //发信人昵称
    $phpmailer->From = ghost_get_option('From'); //显示的发信邮箱
    $phpmailer->Host = ghost_get_option('Host'); //邮箱的SMTP服务器地址
    $phpmailer->Port = ghost_get_option('Port'); //SMTP服务器端口
    $phpmailer->SMTPSecure = ghost_get_option('SMTPSecure') ? 'ssl':'tls'; //SMTP加密方式tls/ssl/no(不填)
    $phpmailer->Username = ghost_get_option('Username'); //邮箱地址
    $phpmailer->Password = ghost_get_option('Password'); //邮箱密码
}
add_action( 'phpmailer_init', 'mail_smtp', 10, 1);

//html格式邮件
function tpl_email_html($user, $title, $desc)
{
    $html = '<div style="background-color:#eef2fa;border:1px solid #d8e3e8;color: #111;padding:0 15px;-moz-border-radius:5px;-webkit-border-radius:5px;-khtml-border-radius:5px;">';
    $html .= '<p style="font-weight: bold;color: #2196F3;font-size: 18px;">'.$title.'</p>';
    $html .= sprintf("<p>您好，%s</p>", $user);
    $html .= sprintf("<p>内容: %s</p>", $desc);
    $html .= sprintf("<p>时间: %s</p>", date("Y-m-d H:i:s"));
    $a_href = '<a href="'.home_url().'">'.get_bloginfo('name').'</a>';
    $html .= sprintf("<p>官网： %s</p>", $a_href);
    $html .= '</div>';
    return $html;
}

//发送html格式邮件
function sendMail($email, $title, $message)
{
    $headers    = array('Content-Type: text/html; charset=UTF-8');
    $message = tpl_email_html($email, $title, $message);
    $send_email = wp_mail($email, $title, $message, $headers);
    if ($send_email) {
        return true;
    }
    return false;
}

// 验证码生成
function sessioncode($email)
{
    session_start();
    $originalcode = '0,1,2,3,4,5,6,7,8,9';
    $originalcode = explode(',', $originalcode);
    $countdistrub = 10;
    $_dscode      = "";
    $counts       = 6;
    for ($j = 0; $j < $counts; $j++) {
        $dscode = $originalcode[rand(0, $countdistrub - 1)];
        $_dscode .= $dscode;
    }
    $_SESSION['ghost_verify_code']      = strtolower($_dscode);
    $_SESSION['ghost_verify_email']     = $email;
    $message                            = '验证码：' . $_dscode;
    $send_email                         = sendMail($email, '验证码', $message);
    if ($send_email) {
        return true;
    }
    return false;
}

// 验证注册邮箱
function verify_reg_email()
{
    global $wpdb;
    $headers    = array('Content-Type: text/html; charset=UTF-8');
    $user_email = !empty($_POST['user']['email']) ? esc_sql($_POST['user']['email']) : null;
    $user_email = apply_filters('user_registration_email', $user_email);
    $user_email = $wpdb->_escape(trim($user_email));

    if (email_exists($user_email)) {
		$result['status']	= 0;
		$result['msg'] 	= '已存在';		
    } else {
        $send_email = sessioncode($user_email);
        if ($send_email) {
			$result['status']	= 1;
			$result['msg'] 	= '发送成功';
        } else {
			$result['status']	= 0;
			$result['msg'] 	= '发送失败';
        }
    }
	header( 'content-type: application/json; charset=utf-8' );
	echo json_encode( $result );
	exit;	
}
add_action('wp_ajax_verify_reg_email', 'verify_reg_email');
add_action('wp_ajax_nopriv_verify_reg_email', 'verify_reg_email');

// 验证忘记密码邮箱
function verify_forget_email()
{
    global $wpdb;
    $headers    = array('Content-Type: text/html; charset=UTF-8');
    $user_email = !empty($_POST['user']['email']) ? esc_sql($_POST['user']['email']) : null;
    $user_email = apply_filters('user_registration_email', $user_email);
    $user_email = $wpdb->_escape(trim($user_email));

    $send_email = sessioncode($user_email);
    if ($send_email) {
        $result['status']	= 1;
        $result['msg'] 	= '发送成功';
    } else {
        $result['status']	= 0;
        $result['msg'] 	= '发送失败';
    }
	header( 'content-type: application/json; charset=utf-8' );
	echo json_encode( $result );
	exit;	
}
add_action('wp_ajax_verify_forget_email', 'verify_forget_email');
add_action('wp_ajax_nopriv_verify_forget_email', 'verify_forget_email');

// 小工具注册
register_sidebar(array(
    'name' => '首页小工具',
    'id' => 'sidebar_index',
    'before_widget' => '<div class="%2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
    'description'   => '首页小工具',
));
register_sidebar(array(
    'name' => '文章小工具',
    'id' => 'sidebar_post',
    'before_widget' => '<div class="%2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
    'description'   => '文章小工具',
));
register_sidebar(array(
    'name' => '页面小工具',
    'id' => 'sidebar_page',
    'before_widget' => '<div class="%2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
    'description'   => '页面小工具',
));
require($require_url.'/widget/hot-post.php');
require($require_url.'/widget/author.php');

// seo
function ghost_seo_quota_encode($value) {
	$value = str_replace('"','&#34;',$value);
	$value = str_replace("'",'&#39;',$value);
	return $value;
}

function ghost_seo_get_post_meta($post_id,$key) {
	$value = get_post_meta($post_id,$key,true);
	$value = stripslashes($value);
	return $value;
}
function ghost_seo_get_term_meta($term_id,$key) {
	$value = get_term_meta($term_id,$key,true);
	$value = stripslashes($value);
	return $value;
}
/*
* 获取用户页面的 url 网址
* $user_id 用户的ID，必要项（int）
* $type 用户页面的参数，非必要项 （array）,例如  array('key','value')
*/
function ghost_get_user_page_url($user_id = 0,$type = ''){

    if(!$user_id) $user_id = get_the_author_meta( 'ID' );

    $url = home_url('/user/'.$user_id);

    if(!$type){
        return esc_url($url);
    }else{
        return esc_url($url.'/'.$type);
    }
}

//获取文章描述
function ghost_get_post_des($post_id){
	if(!$post_id){
		global $post;
		$post_id = $post->ID;
	}

	$post_meta = ghost_seo_get_post_meta($post_id, 'ghost_seo_description');
	$post_excpert = get_post_field('post_excerpt',$post_id);
	$post_content = ghost_get_content_ex(get_post_field('post_content',$post_id),150);

	//如果存在SEO描述输出，否则输出文章摘要，否则输出文章内容截断
	$description = $post_meta ? $post_meta : ($post_excpert ? $post_excpert : $post_content);

	return trim(strip_tags($description));
}
/*
* 获取文章摘要
* $content 需要截断的字符串 (string)
* $size 截断的长度 (int)
*/
function ghost_get_content_ex($content = '',$size = 130){

    if(!$content){
        global $post;
        $excerpt = $post->post_excerpt;
        $content = $excerpt ? $excerpt : $post->post_content;
    }

    return mb_strimwidth(ghost_clear_code(strip_tags(strip_shortcodes($content))), 0, $size,'...');

}
/*
* 清除字符串中的标签
*/
function ghost_clear_code($string){
    $string = trim($string);
    if(!$string)
        return '';
    $string = preg_replace('/[#][1-9]\d*/','',$string);//清除图片索引（#n）
    $string = str_replace("\r\n",' ',$string);//清除换行符
    $string = str_replace("\n",' ',$string);//清除换行符
    $string = str_replace("\t",' ',$string);//清除制表符
    $pattern = array("/> *([^ ]*) *</","/[\s]+/","/<!--[^!]*-->/","/\" /","/ \"/","'/\*[^*]*\*/'","/\[(.*)\]/");
    $replace = array(">\\1<"," ","","\"","\"","","");
    return preg_replace($pattern,$replace,$string);
}

/*
* 获取评论中第 N 张图片
* $content 通常为文章内容,也可以是其他任意字符串(string)
* $i 返回第几章图片 (int)
*/
function ghost_get_first_img($content,$i = 0) {
    preg_match_all('~<img[^>]*src\s?=\s?([\'"])((?:(?!\1).)*)[^>]*>~i', $content, $match,PREG_PATTERN_ORDER);

    if(is_numeric($i)){
        return isset($match[2][$i]) ? esc_url($match[2][$i]) : '';
    }elseif($i == 'all'){
        return $match[2];
    }else{
        return isset($match[2][0]) ? esc_url($match[2][0]) : '';
    }
}
function ghost_get_html_code($str){
    return str_replace('\\','',$str);
}

// 将关键词和描述输出在wp_head区域
add_action('wp_head','ghost_seo_head_meta',0);
function ghost_seo_head_meta(){
	echo '<title>'.my_title().'</title>'."\n";
	echo ghost_seo_head_meta_keywords()."\n";
	echo ghost_get_html_code('');
	echo '<link rel="shortcut icon" href="'.ghost_get_option('header_site_icon').'" />'."\n";
}

function _get_tax_meta($id = 0, $field = '')
{
    $ops = get_option("_taxonomy_meta_$id");

    if (empty($ops)) {
        return '';
    }

    if (empty($field)) {
        return $ops;
    }

    return isset($ops[$field]) ? $ops[$field] : '';
}

//seo 标题
function my_title()
{

    global $paged,$post;

    $html = '';
    if(get_query_var('ghost_page_type')=='setting'){
        $html.= '信息修改 - '.get_bloginfo('name');
    }elseif(get_query_var('ghost_page_type')=='drafts'){
        $html.= '我的草稿 - '.get_bloginfo('name');
    }elseif(get_query_var('ghost_page_type')=='newpost'){
        $html.= '新建文章 - '.get_bloginfo('name');
    }elseif(get_query_var('ghost_page_type')=='notice'){
        $html.= '我的通知 - '.get_bloginfo('name');
    }elseif(get_query_var('ghost_page_type')=='msg'){
        $html.= '我的消息 - '.get_bloginfo('name');
    }elseif(get_query_var('ghost_page_type')=='orders'){
        $html.= '我的订单 - '.get_bloginfo('name');
    }elseif(get_query_var('ghost_page_type')=='vip'){
        $html.= '我的会员 - '.get_bloginfo('name');
    }elseif(get_query_var('ghost_page_type')=='cash'){
        $html.= '我的余额 - '.get_bloginfo('name');
    }elseif(get_query_var('ghost_page_type')=='credits'){
        $html.= '我的积分 - '.get_bloginfo('name');
    }elseif(get_query_var('ghost_page_type')=='shop'){
		   $html.= '我的商城 - '.get_bloginfo('name');
    }elseif(get_query_var('ghost_page_type')=='price'){
        $html.= '积分抽奖 - '.get_bloginfo('name');
    }elseif (is_category()) {
        $html .= single_cat_title('',false).' - '.get_bloginfo('name');
    }elseif (is_tag()) {
        $html .= single_cat_title('',false).' - '.get_bloginfo('name');
    }elseif (is_single()) {
        global $post;
	    $post_id = $post->ID;
        $html .= get_the_title($post_id).' - '.get_bloginfo('name');
    }elseif(is_search()){
        $html.= '['.get_search_query().']的匹配结果'.' - '.get_bloginfo('name');
    }elseif (is_home()) {
        $html .= get_bloginfo('name').' - '.get_option('blogdescription');
    }elseif (is_author()) {
        $user_id =  get_query_var('author');
        $user_data = get_userdata($user_id);
        $html .= $user_data->nickname.'的个人主页 - '.get_bloginfo('name');
    }elseif (is_page()) {
        global $post;
	    $post_id = $post->ID;
        $html .= get_post_meta($post_id,'ghost_seo_title',true).' - '.get_bloginfo('name');
    }

    return $html;
}

// 网页关键字与og标签
function ghost_seo_head_meta_keywords(){
    if(is_paged())
    {
        return;
    }

    $keywords = '';
    $og = '';
    $title = ghost_get_option('ghost_site_name');
	$logo = ghost_get_option('ghost_site_logo');
    if(is_home() || is_front_page()){
        $keywords = ghost_get_option('ghost_site_word');
        $dec = ghost_get_option('ghost_site_dec');
        $og = '
<meta property="og:site_name" content="'.$title.'" />
<meta property="og:type" content="website" />
<meta property="og:title" content="'.$title.'" />
<meta property="og:url" content="'.home_url().'" />
<meta property="og:image" content="'.$logo.'" />';
    }elseif(is_category() || is_tax()){
	    $cat = get_queried_object()->term_id;
	    $cat_name = single_cat_title('',false);
	    $keywords = ghost_seo_get_term_meta($cat,'seo_keywords');
        $keywords = $keywords ? $keywords : $cat_name;
        $og = '
<meta property="og:type" content="website" />
<meta property="og:site_name" content="'.$title.'" />
<meta property="og:title" content="'.$cat_name.'" />
<meta property="og:url" content="'.get_category_link( $cat ).'" />
<meta property="og:image" content="'.$logo.'" />';
    }elseif(is_tag()){
        global $wp_query;
        $tag_name = single_cat_title('',false);
        $tag_id = $wp_query->queried_object->term_id;
        $keywords = ghost_seo_get_term_meta($tag_id,'seo_keywords');
        $keywords = $keywords ? $keywords : $tag_name;
        $og = '
<meta property="og:type" content="website" />
<meta property="og:site_name" content="'.$title.'" />
<meta property="og:title" content="'.$tag_name.'" />
<meta property="og:url" content="'.get_tag_link( $tag_id ).'" />
<meta property="og:image" content="'.$logo.'" />';
    }elseif(is_single()){
        global $post;
	    $post_id = $post->ID;
        $post_cats = strip_tags(get_the_category_list( ',', 'multiple', $post_id ));
        $post_tags = strip_tags(get_the_tag_list('',',',''));
        $post_meta = ghost_seo_get_post_meta($post_id, 'ghost_seo_keywords');
        $keywords = $post_meta ? $post_meta : $post_tags.($post_tags ? ',' : '').$post_cats;
        $author_id = get_post_field( 'post_author', $post_id );
        $thumb = get_the_post_thumbnail_url($post_id) ? get_the_post_thumbnail_url($post_id) : ghost_get_first_img(get_post_field('post_content', $post_id));
        $og = '
<meta property="og:site_name" content="'.$title.'" />
<meta property="og:type" content="article" />
<meta property="og:url" content="'.get_permalink($post_id).'" />
<meta property="og:title" content="'.get_the_title($post_id).'" />
<meta property="og:updated_time" content="'.get_the_modified_date('c',$post_id).'" />
<meta property="og:image" content="'.$thumb.'" />
<meta property="article:published_time" content="'.get_the_time('c',$post_id).'" />
<meta property="article:modified_time" content="'.get_the_modified_date('c',$post_id).'" />
<meta property="article:author" content="'.ghost_get_user_page_url($author_id).'" />
<meta property="article:publisher" content="'.home_url().'" />';
    }elseif(is_singular()){
        global $post;
        $post_id = $post->ID;
        $keywords = ghost_seo_get_post_meta($post->ID, 'ghost_seo_keywords');
        $author_id = get_post_field( 'post_author', $post_id );
        $og = '
<meta property="og:site_name" content="'.$title.'" />
<meta property="og:type" content="article" />
<meta property="og:url" content="'.get_permalink($post_id).'" />
<meta property="og:title" content="'.get_the_title($post_id).'" />
<meta property="og:updated_time" content="'.get_the_modified_date('c',$post_id).'" />
<meta property="og:image" content="'.(get_the_post_thumbnail_url($post_id) ? get_the_post_thumbnail_url($post_id) : ghost_get_first_img(get_post_field('post_content', $post_id))).'" />
<meta property="article:published_time" content="'.get_the_time('c',$post_id).'" />
<meta property="article:modified_time" content="'.get_the_modified_date('c',$post_id).'" />
<meta property="article:author" content="'.ghost_get_user_page_url($author_id).'" />
<meta property="article:publisher" content="'.home_url().'" />';
    }elseif(is_search()){
        $og = '
<meta property="og:site_name" content="'.$title.'" />
<meta name="description" content="与['.get_search_query().']匹配的结果">
<meta name="keywords" content="'.get_search_query().'">';
    }

    $keywords = trim(strip_tags($keywords));
    $og .= '<link rel="alternate" type="application/atom+xml" title="'.$title.' Atom Feed" href="'.home_url().'/feed/atom">
            <link rel="alternate" type="application/rss+xml" title="'.$title.' RSS Feed" href="'.home_url().'/feed">';
    $og = trim($og);
    if($keywords)
    {
        $keywords = '<meta name="keywords" content="'.$keywords.'" />'."\n";
    }
    return $keywords.ghost_seo_head_meta_description().$og;
}

// 网页描述
function ghost_seo_head_meta_description($weixin = false){
    if(is_paged())
    {
        return;
    }
    $description = '';
    $og = '';
    if(is_home() || is_front_page()){
        $description =  ghost_get_option('ghost_site_dec');
    }elseif(is_category() || is_tax()){
        $description = category_description();
    }elseif(is_tag()){
        $description = tag_description();
    }elseif(is_single() || is_singular()){
        global $post;
        $description = ghost_get_post_des($post->ID);
    }

    $description = strip_tags($description);
    $description = trim($description);

    if($weixin) return $description;
    
    if($description)
    {
        return '<meta name="description" content="'.$description.'" />'."\n".'<meta property="og:description" content="'.$description.'" />'."\n";
    }
    return '';
}

// 自定义页面
function ghost_def_page() {
    global $ghost_page_type;
    $ghost_page_type = apply_filters( 'ghost_page_type',array('setting','cash','credits','drafts','msg','newpost','notice','orders','price','vip','answer','shop','edit_post'));
    //注册主题自定页面
    add_rewrite_tag('%ghost_page_type%','([^&]+)');
    
}
add_action( 'init','ghost_def_page',10,0 );

//注册路由规则
function ghost_rewrite_rules( $wp_rewrite ) {
    global $ghost_page_type;
    $new_rules = array();
    $deflink = empty(ghost_get_option('ghost_site_me_link')) ? 'me' : ghost_get_option('ghost_site_me_link');
    $new_rules[$deflink.'/([0-9]+)/?'] = 'index.php?ghost_page_type=directmessage&pink_muser=$matches[1]';
    foreach ($ghost_page_type as $page) {
        $new_rules[$deflink.'/'.$page] = 'index.php?ghost_page_type='.$page;
    }
    $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
    return $wp_rewrite;
}
add_filter('generate_rewrite_rules','ghost_rewrite_rules');

//加载自定义模板
function ghost_template_redirects() {
    $type = get_query_var('ghost_page_type');
    
    if ($type) {
        require(get_template_directory().'/page/mydef/'.$type.'.php');
        exit;
    }
}
add_filter( 'template_redirect', 'ghost_template_redirects' );

//更改作者存档前缀
add_action('init', 'ghost_change_author_base');
function ghost_change_author_base() {
  global $wp_rewrite;
   $author = empty(ghost_get_option('ghost_site_author_link')) ? 'author' : ghost_get_option('ghost_site_author_link');
  $author_slug = $author;
  $wp_rewrite->author_base = $author_slug;
}

// 获取用户主页链接
function ghost_get_user_author_link($user_id){
    $author = empty(ghost_get_option('ghost_site_author_link')) ? 'author' : ghost_get_option('ghost_site_author_link');
    return home_url('/'.$author.'/'.$user_id);
}

//修改作者id为存档页链接
add_filter( 'request', 'ghost_author_link_request' );
function ghost_author_link_request( $query_vars ) {
    if ( array_key_exists( 'author_name', $query_vars ) ) {
        global $wpdb;
        $author_id=$query_vars['author_name'];
        if ( $author_id ) {
            $query_vars['author'] = $author_id;
            unset( $query_vars['author_name'] );    
        }
    }
    return $query_vars;
}

// 个人中心ajax
function submit_setting(){
    global $current_user;
    $user_id = $current_user->ID;
    if(!is_user_logged_in()){ exit;}
    $name = $_POST['msg']['name'];
    $dec = $_POST['msg']['dec'];
    if($user_id){
        update_usermeta($user_id,'nickname',ghost_get_html_code($name));
        update_usermeta($user_id,'description',ghost_get_html_code($dec));
        $result['code']	= 1;
		$result['message'] = '更新成功';
    }else{
        $result['code']	= 0;
        $result['message'] = '更新失败';
    }
	header( 'content-type: application/json; charset=utf-8' );
	echo json_encode( $result );
	exit;
}
add_action( 'wp_ajax_submit_setting', 'submit_setting' );
add_action( 'wp_ajax_nopriv_submit_setting', 'submit_setting' );

// 上传头像avatar_photo
function update_avatar_photo()
{
    header('Content-type:application/json; Charset=utf-8');
    global $current_user;
    $uid = $current_user->ID;
    if(!is_user_logged_in()){ exit;}
    $nonce   = !empty($_POST['nonce']) ? $_POST['nonce'] : null;
    $file = !empty($_FILES['file']) ? $_FILES['file'] : null;
    if ($nonce && !wp_verify_nonce($nonce, 'ghostavatar-' . $uid)) {
        $result['code']	= 0;
        $result['message'] = '非法请求';
    }

    if (is_uploaded_file($file['tmp_name']) && is_user_logged_in()) {
        $picname = $file['name'];
        $picsize = $file['size'];
        $arrType = array('image/jpg', 'image/gif', 'image/png', 'image/bmp', 'image/pjpeg', "image/jpeg");
		   $avatar_email_msg = get_user_meta($uid,'avatar_email_msg',true);
			$avatar_email_msg = isset($avatar_email_msg) ? $avatar_email_msg : ghost_get_option('avatar_email_msg');
        $rand    = (rand(10, 100));
			$del_credit = ghost_get_option('avatar_credit_msg');
        if ($picname != "") {
            if ($picsize > 1024*1024*ghost_get_option('pic_avatar_size')) {
                $result['code']	= 0;
                $result['message'] = '尺寸限制'.ghost_get_option('pic_avatar_size').'M';
            } elseif (!in_array($file['type'], $arrType)) {
                $result['code']	= 0;
                $result['message'] = '图片类型错误';
            } else {
                $pics = 'avatar-' . $uid . '.jpg';
                // 上传生成的海报图片至指定文件夹
                $upload_dir = wp_upload_dir();
                $upfile = $upload_dir['basedir'] . '/avatar/';
                if (!is_dir($upfile)) {
                    wp_mkdir_p($upfile);
                }

                if( ghost_get_option('ghost_oss')==true ){
                    // 上传文件到阿里云oss
                    $AliyunOss = new AliyunOss();
                    $res = upload_File($file,'avatar_img/'.$uid,$upfile,$uid);
                    $result = $AliyunOss->upload_file($res['dest'],$res['fname']);
                    if (get_user_meta($uid,'user_credit',true)>0 && get_user_meta($uid,'user_credit',true)+$del_credit>0 ) {
                        update_user_meta($uid, 'ghost_user_avatar', $result['oss_file']);
                        $credit = ghost_update_user_credit($uid,ghost_get_option('avatar_credit_msg'),'avatar');
                        if($avatar_email_msg){
                            sendMail($current_user->user_email, '修改头像', '您的头像修改成功！扣除积分：'.$del_credit.'剩余积分：'.$credit);
                        }
                        $result['code']	= 1;
                        $result['message'] = '更新成功';
                    } else {
                        $result['code']	= 0;
                        $result['message'] = '积分不足';
                    }
                }else{
                    //本低上传
                    $res = upload_File($file,'avatar_img/'.$uid,$upfile,$uid);
                    if (get_user_meta($uid,'user_credit',true)>0 && get_user_meta($uid,'user_credit',true)+$del_credit>0 ) {
                        update_user_meta($uid, 'ghost_user_avatar', $upload_dir['baseurl'] . '/avatar/' . $res['file_name']);
                        $credit = ghost_update_user_credit($uid,ghost_get_option('avatar_credit_msg'),'avatar');
                        if($avatar_email_msg){
                            sendMail($current_user->user_email, '修改头像', '您的头像修改成功！扣除积分：'.$del_credit.'剩余积分：'.$credit);
                        }
                        $result['code']	= 1;
                        $result['message'] = '更新成功';
                    } else {
                        $result['code']	= 0;
                        $result['message'] = '积分不足';
                    }
                }
            }
        }
    }else{
        $result['code']	= 0;
        $result['message'] = '文件错误';
    }
	echo json_encode( $result );
	exit;
}
add_action('wp_ajax_update_avatar_photo', 'update_avatar_photo');
add_action('wp_ajax_nopriv_update_avatar_photo', 'update_avatar_photo');

// 发送修改邮箱
function verify_change_email()
{
    global $wpdb;
    if(!is_user_logged_in()) exit;
	header( 'content-type: application/json; charset=utf-8' );
    $user_email = !empty($_POST['user']['email']) ? esc_sql($_POST['user']['email']) : null;
    $user_email = apply_filters('user_registration_email', $user_email);
    $user_email = $wpdb->_escape(trim($user_email));

    if (email_exists($user_email)) {
		$result['status']	= 0;
		$result['msg'] 	= '已存在';		
    } else {
        $send_email = sessioncode($user_email);
        if ($send_email) {
			$result['status']	= 1;
			$result['msg'] 	= '发送成功';
        } else {
			$result['status']	= 0;
			$result['msg'] 	= '发送失败';
        }
    }
	echo json_encode( $result );
	exit;	
}
add_action('wp_ajax_verify_change_email', 'verify_change_email');
add_action('wp_ajax_nopriv_verify_change_email', 'verify_change_email');

// 提交修改邮箱
function change_email()
{
    global $wpdb,$current_user;
	$del_credit = ghost_get_option('myemail_credit_msg');
    session_start();
    if(!is_user_logged_in()) exit;
	header( 'content-type: application/json; charset=utf-8' );
    if(isset($_POST['user']['emailnonce']) && wp_verify_nonce( $_POST['user']['emailnonce'], 'ghostemail-'.$current_user->ID ) ){
        $user_email = trim(htmlspecialchars($_POST['user']['email']));
        $user_code = (int)$_POST['user']['yanzhengma'];

        if (email_exists($user_email)) {
            $result['status']	= 0;
            $result['msg'] 	= '已存在';
        } else {
            if ($_SESSION['ghost_verify_email']==$user_email && $_SESSION['ghost_verify_code']==$user_code) {
				if(get_user_meta($current_user->ID,'user_credit',true)>0 && get_user_meta($current_user->ID,'user_credit',true)+$del_credit>0){
                $data = array();
                $data['ID'] = $current_user->ID;
                $data['user_email'] = $user_email;
                wp_update_user($data);
						$credit = ghost_update_user_credit($current_user->ID,ghost_get_option('myemail_credit_msg'),'myemail');
						$myemail_email_msg = get_user_meta($current_user->ID,'myemail_email_msg',true);
						$myemail_email_msg = isset($myemail_email_msg) ? $myemail_email_msg : ghost_get_option('myemail_email_msg');
                if($myemail_email_msg){
                    sendMail($current_user->user_email, '修改邮箱', '您的新邮箱为：'.$user_email);
                }
                $result['status']	= 1;
                $result['msg'] 	= '修改成功';
					} else {
						$result['status']	= 0;
						$result['msg'] 	= '积分不足';
					}
            } else {
                $result['status']	= 0;
                $result['msg'] 	= '修改失败';
            }
        }
    }else{
        $result['status']	= 0;
        $result['msg'] 	= '验证失败';
    }
	echo json_encode( $result );
	exit;	
}
add_action('wp_ajax_change_email', 'change_email');
add_action('wp_ajax_nopriv_change_email', 'change_email');

// 提交修改密码
function change_pwd()
{
    global $wpdb,$current_user;
    $user_id = $current_user->ID;
	$del_credit = ghost_get_option('pwd_credit_msg');
    if(!is_user_logged_in()) exit;
	header( 'content-type: application/json; charset=utf-8' );
    if(isset($_POST['user']['pwdnonce']) && wp_verify_nonce( $_POST['user']['pwdnonce'], 'ghostpwd-'.$current_user->ID ) ){
        $oldpwd = trim(htmlspecialchars($_POST['user']['oldpwd']));
        $newpwd = trim(htmlspecialchars($_POST['user']['newpwd']));
        $new_pwd = trim(htmlspecialchars($_POST['user']['new_pwd']));

        if (strlen($oldpwd)>=6 && $newpwd==$new_pwd && get_user_meta($user_id,'user_credit',true)) {
            if(get_user_meta($user_id,'user_passwd',true)==$oldpwd){
				if(get_user_meta($user_id,'user_credit',true)>0 && get_user_meta($user_id,'user_credit',true)+$del_credit>0){
                $arr = array(
                    'user_pass'=>$new_pwd,
                    'ID'=>$user_id,
                );
                $user_id = wp_update_user($arr);
                wp_cache_delete($user_id, 'users');
                $creds = array('user_login' => $user_id, 'user_password' => $pass, 'remember' => true);
                wp_signon($creds,true);
                wp_cache_flush();
						$credit = ghost_update_user_credit($user_id,ghost_get_option('pwd_credit_msg'),'pwd');
						$pwd_email_msg = get_user_meta($user_id,'pwd_email_msg',true);
						$pwd_email_msg = isset($pwd_email_msg) ? $pwd_email_msg : ghost_get_option('pwd_email_msg');
                if($pwd_email_msg){
                    sendMail($current_user->user_email, '修改密码', '密码修改成功！');
                }
                update_user_option($user_id,'user_passwd',$new_pwd,true);
                $result['status']	= 1;
                $result['msg'] 	= '修改成功';
					}else{
						$result['status']	= 0;
						$result['msg'] 	= '积分不足';
					}
            }else{
                $result['status']	= 0;
                $result['msg'] 	= '原密码输入错误';
            }
        } else if($newpwd!=$new_pwd){
            $result['status']	= 0;
            $result['msg'] 	= '二次密码不一样';
        }else{
            $result['status']	= 0;
            $result['msg'] 	= '密码长度小于6';
        }
    }else{
        $result['status']	= 0;
        $result['msg'] 	= '验证失败';
    }
	echo json_encode( $result );
	exit;	
}
add_action('wp_ajax_change_pwd', 'change_pwd');
add_action('wp_ajax_nopriv_change_pwd', 'change_pwd');

// 提交修改其他
function change_switch()
{
    global $wpdb,$current_user;
    $user_id = $current_user->ID;
    session_start();
    if(!is_user_logged_in()) exit;
	header( 'content-type: application/json; charset=utf-8' );
    if(isset($_POST['user']['switchnonce']) && wp_verify_nonce( $_POST['user']['switchnonce'], 'ghostswitch-'.$current_user->ID ) ){
        $show_ip = trim(htmlspecialchars($_POST['user']['show_ip']));
        $login_email_msg = trim(htmlspecialchars($_POST['user']['login_email_msg']));
        $forget_email_msg = trim(htmlspecialchars($_POST['user']['forget_email_msg']));
        $pwd_email_msg = trim(htmlspecialchars($_POST['user']['pwd_email_msg']));
        $myemail_email_msg = trim(htmlspecialchars($_POST['user']['myemail_email_msg']));
        $avatar_email_msg = trim(htmlspecialchars($_POST['user']['avatar_email_msg']));
        $comment_email_msg = trim(htmlspecialchars($_POST['user']['comment_email_msg']));
        $post_email_msg = trim(htmlspecialchars($_POST['user']['post_email_msg']));
        $buy_download_link = trim(htmlspecialchars($_POST['user']['buy_download_link']));
        $message_email_msg = trim(htmlspecialchars($_POST['user']['message_email_msg']));
			update_user_meta($user_id,'show_ip',$show_ip);
			update_user_meta($user_id,'login_email_msg',$login_email_msg);
			update_user_meta($user_id,'forget_email_msg',$forget_email_msg);
			update_user_meta($user_id,'pwd_email_msg',$pwd_email_msg);
			update_user_meta($user_id,'myemail_email_msg',$myemail_email_msg);
			update_user_meta($user_id,'avatar_email_msg',$avatar_email_msg);
			update_user_meta($user_id,'comment_email_msg',$comment_email_msg);
			update_user_meta($user_id,'post_email_msg',$post_email_msg);
			update_user_meta($user_id,'buy_download_link',$buy_download_link);
			update_user_meta($user_id,'message_email_msg',$message_email_msg);
        $result['status']	= 1;
			$result['msg'] 	= '修改成功';
    }else{
        $result['status']	= 0;
        $result['msg'] 	= '验证失败';
    }
	echo json_encode( $result );
	exit;	
}
add_action('wp_ajax_change_switch', 'change_switch');
add_action('wp_ajax_nopriv_change_switch', 'change_switch');

// 提交文章评论信息
function submit_comments()
{
    global $wpdb,$current_user;
    $user_id = $current_user->ID;
    if(!is_user_logged_in()) exit;
	header( 'content-type: application/json; charset=utf-8' );
    if(!empty($_POST['comment']['content'])){
        $content = trim(htmlspecialchars($_POST['comment']['content']));
    }else{
        $result['status']	= 0;
        $result['msg'] 	= '请输入评论';
        echo json_encode( $result );exit;
    }
    $post_id = (int)$_POST['comment']['post_id'];
    if(isset($_POST['comment']['commentnonce']) && wp_verify_nonce( $_POST['comment']['commentnonce'], 'comment_security_nonce' ) && get_user_meta($user_id,'user_credit',true)>0 && get_post_status($post_id)=='publish' ){
        
        $args = array(
            'comment_post_ID' => $post_id,
            'user_id' => $user_id,
            'comment_content' => $content,
            'comment_approved' => 1
        );
        $comment_id = wp_insert_comment( $args,true);
        $credit = ghost_update_user_credit($user_id,ghost_get_option('comment_credit_msg'),'postcomment',$post_id);
			$comment_email_msg = get_user_meta($user_id,'comment_email_msg',true);
			$comment_email_msg = isset($comment_email_msg) ? $comment_email_msg : ghost_get_option('comment_email_msg');
        if($comment_email_msg){
            sendMail($current_user->user_email, '提交评论', '您在文章'.get_permalink($post_id).'的评论提交成功！');
        }
        $result['status']	= 1;
        $result['msg'] 	= '评论成功';
    }else{
        $result['status']	= 0;
        $result['msg'] 	= '验证失败';
    }
	echo json_encode( $result );
	exit;	
}
add_action('wp_ajax_submit_comments', 'submit_comments');
add_action('wp_ajax_nopriv_submit_comments', 'submit_comments');

// 提交文章报告信息
function submit_reports()
{
    global $wpdb,$current_user;
    $user_id = $current_user->ID;
    if(!is_user_logged_in()) exit;
	header( 'content-type: application/json; charset=utf-8' );
    $post_id = (int)$_POST['post_id'];
    $report = trim(htmlspecialchars($_POST['report']));
    $report_container = isset($_POST['report_container']) ? trim(htmlspecialchars($_POST['report_container'])) : '';
    if(isset($_POST['reportnonce']) && wp_verify_nonce( $_POST['reportnonce'], 'report_security_nonce' ) && isset( $_POST['report'] ) ){
        global $wpdb;
        $table_name=$wpdb->prefix.'ghost_report';
        $msg_time=current_time('mysql');
        $wpdb->query( "INSERT INTO $table_name (type,user_id,post_id,container,msg_time) VALUES ('$report','$user_id','$post_id','$report_container','$msg_time')" );
    
        $result['status']	= 1;
        $result['msg'] 	= '提交成功';
    }else{
        $result['status']	= 0;
        $result['msg'] 	= '提交失败';
    }
	echo json_encode( $result );
	exit;	
}
add_action('wp_ajax_submit_reports', 'submit_reports');
add_action('wp_ajax_nopriv_submit_reports', 'submit_reports');

// 提交用户评论信息
function submit_usercomments()
{
    global $wpdb,$current_user;
    $user_id = $current_user->ID;
    if(!is_user_logged_in()) exit;
	header( 'content-type: application/json; charset=utf-8' );
    if(!empty($_POST['comment']['content'])){
        $content = trim(htmlspecialchars($_POST['comment']['content']));
    }else{
        $result['status']	= 0;
        $result['msg'] 	= '请输入评论';
        echo json_encode( $result );exit;
    }
    $post_id = (int)$_POST['comment']['post_id'];
    $commentid = (int)$_POST['comment']['commentid'];
    if(isset($_POST['comment']['commentnonce']) && wp_verify_nonce( $_POST['comment']['commentnonce'], 'comment_security_nonce' ) && get_user_meta($user_id,'user_credit',true)>0 && get_post_status($post_id)=='publish'){
        
        $args = array(
            'comment_post_ID' => $post_id,
            'user_id' => $user_id,
            'comment_content' => $content,
            'comment_parent' => $commentid,
            'comment_approved' => 1
        );
        $comment_id = wp_insert_comment( $args,true);
        $credit = ghost_update_user_credit($user_id,ghost_get_option('comment_credit_msg'),'usercomment',$post_id,$commentid);
        update_comment_meta($comment_id,'comments_user_id',get_comment( $commentid )->user_id);
			$comment_email_msg = get_user_meta($user_id,'comment_email_msg',true);
			$comment_email_msg = isset($comment_email_msg) ? $comment_email_msg : ghost_get_option('comment_email_msg');
        if($comment_email_msg){
            sendMail($current_user->user_email, '提交评论', '您在文章'.get_permalink($post_id).'的评论提交成功！');
        }
        $result['status']	= 1;
        $result['msg'] 	= '评论成功';
    }else{
        $result['status']	= 0;
        $result['msg'] 	= '验证失败';
    }
	echo json_encode( $result );
	exit;	
}
add_action('wp_ajax_submit_usercomments', 'submit_usercomments');
add_action('wp_ajax_nopriv_submit_usercomments', 'submit_usercomments');

// 收藏文章
function post_stars(){
    if(!get_current_user_id()){
        exit(json_encode(['msg'=>'请先登录才能收藏哦!']));
    }
    $id = $_POST["post_id"];
    $meta = get_post_meta($id,'post_stars',true);
    $shoucang1 = explode(',',get_post_meta($id,'post_stars',true));
    $shoucang =  array_filter($shoucang1); 
    $user = get_current_user_id();
    if($id){
		if(in_array($user,$shoucang)){
			foreach($shoucang as $k=>$v){
				if($v==$user){
					unset($shoucang[$k]);
				}
			}
			update_post_meta($id, 'post_stars', implode(",",$shoucang));
			$result['status']	= 2;
			$result['msg'] 	= '取消收藏成功';
		}else{
			array_push($shoucang,$user);
			update_post_meta($id, 'post_stars', implode(",",$shoucang));
			$result['status']	= 1;
			$result['msg'] 	= '收藏成功';
		}
	}else{
		$result['status']	= 0;
		$result['msg'] 	= '收藏失败';
	}
	header( 'content-type: application/json; charset=utf-8' );
	echo json_encode( $result );
	exit;	
}
add_action('wp_ajax_post_stars', 'post_stars');
add_action('wp_ajax_nopriv_post_stars', 'post_stars');

// 点赞用户评论信息
function submit_usercomments_like()
{
    global $wpdb,$current_user;
    $table_name=$wpdb->prefix.'ghost_comment_like';
    $user_id = $current_user->ID;
    $comments_id = $_POST['comments_id'];
    $user_like = $wpdb->query( "SELECT comment_id,user_id FROM wp_ghost_comment_like WHERE comment_id=$comments_id AND user_id=$user_id" );
	header( 'content-type: application/json; charset=utf-8' );
    if(!is_user_logged_in()){
        $result['status']	= 0;
        $result['msg'] 	= '未登录';
        echo json_encode( $result );exit;
    };
    $num = get_comment_meta($comments_id,'comments_like',true);
    if(!$user_like){
        if($num){
            update_comment_meta($comments_id,'comments_like',$num+1);
        }else{
            update_comment_meta($comments_id,'comments_like',1);
        }
        $wpdb->query( "INSERT INTO $table_name (comment_id,user_id,status) VALUES ('$comments_id','$user_id',1)" );
        $result['status']	= 1;
        $result['num'] 	= $num+1;
        $result['msg'] 	= '点赞成功';
    }else{
        $result['status']	= 0;
        $result['msg'] 	= '已点赞';
    }
	echo json_encode( $result );
	exit;
}
add_action('wp_ajax_submit_usercomments_like', 'submit_usercomments_like');
add_action('wp_ajax_nopriv_submit_usercomments_like', 'submit_usercomments_like');

// 积分购买链接
function buy_download_link()
{
    global $current_user;
    $user_id = $current_user->ID;
    $id = $_POST['id'];
    $postid = $_POST['postid'];
    $author_id = $_POST['author_id'];
		$download = get_post_meta($postid,'ghost_download',true);
		$user_metass = json_decode(get_user_meta($user_id,$postid,true));
    header( 'content-type: application/json; charset=utf-8' );
    if(!is_user_logged_in()){
        $result['status']	= 0;
        $result['msg'] 	= '未登录';
        echo json_encode( $result );exit;
    };
    if($user_id && $postid){
		if(get_user_meta($user_id,'user_credit',true)-$download[$id]['credit']>0 && get_user_meta($user_id,'user_credit',true)>0 ){
			if(isset($user_metass)){
				foreach($download as $key => $downloads){
					if($key==$id){
						$user_metass[$key]->type=1;
					}
				}
				update_user_meta($user_id,$postid,json_encode($user_metass, JSON_UNESCAPED_UNICODE));
			}else{
				$user_metalink=array();
				foreach($download as $key => $downloads){
					if($key==$id){
						$user_metalink[$key]->type=1;
					}else{
						$user_metalink[$key]->type=0;
					}
				}
				update_user_meta($user_id,$postid,json_encode($user_metalink, JSON_UNESCAPED_UNICODE));
			}
			$author_earn_credit = (int)$download[$id]['credit']/10;
        $credit = ghost_update_user_credit($user_id,'-'.$download[$id]['credit'],'buy_download_link',$postid,null,null,null,$author_id);
        $author_credit = ghost_update_user_credit($author_id,$author_earn_credit,'earn_download_link_credit',$postid,null,null,null,$user_id);
			$buy_download_link = get_user_meta($user_id,'buy_download_link',true);
			$buy_download_link = isset($buy_download_link) ? $buy_download_link : ghost_get_option('buy_download_link');
        if($buy_download_link){
				sendMail($current_user->user_email, '下载链接购买', '您在文章'.get_permalink($post_id).'的下载链接购买成功！花费：'.$download[$id]['credit'].'积分！当前剩余'.$credit.'积分');
        }
        if($buy_download_link){
				sendMail($current_user->user_email, '下载链接售出', '您的文章'.get_permalink($post_id).'的下载链接售出成功！赚取：'.$author_earn_credit.'积分！当前剩余'.$author_credit.'积分');
        }
        $result['status'] 	= 1;
        $result['msg'] 	= '购买成功';
		}else{
        $result['status'] 	= 0;
        $result['msg'] 	= '积分不足';
		}
    }else{
        $result['status']	= 0;
        $result['msg'] 	= '购买失败';
    }
	echo json_encode( $result );
	exit;
}
add_action('wp_ajax_buy_download_link', 'buy_download_link');
add_action('wp_ajax_nopriv_buy_download_link', 'buy_download_link');

function merge_values(){
    $list = func_get_args();
    while( count( $list ) > 1 ){
        $array1 = array_shift( $list );
        $array2 = array_shift( $list );

        $merged_array = $array1;
        foreach( $array2 as $key => $value ){
            $merged_array[$key] = array_merge( (array)$value, (array)$merged_array[$key] );
            if( is_object( $value ) || is_object( $array1[$key] ) ){
                $merged_array[$key] = (object)$merged_array[$key];
            }
        }

        array_unshift( $list, $merged_array );
    } 
    return current( $list );
}

// 用户补充下载链接
function submit_addlink()
{
    global $current_user;
    $user_id = $current_user->ID;
    $post_id = $_POST['post_id'];
    $links = $_POST['download'];
    header( 'content-type: application/json; charset=utf-8' );
    if(!is_user_logged_in()){
        $result['status']	= 0;
        $result['msg'] 	= '未登录';
        echo json_encode( $result );exit;
    };
   if(isset($links) && $post_id && isset($_POST['addlinknonce']) && wp_verify_nonce( $_POST['addlinknonce'], 'report_security_nonce' ) ){
			if(!empty($links)){
				$download=array();
				$addlinks = get_post_meta( $post_id, 'ghost_download_addlink', true );
				$addlink = $links;
				if($addlinks){
					$download = array_merge_recursive( $addlinks, $addlink );
					update_post_meta( $post_id, 'ghost_download_addlink', $download );
				}else{
					update_post_meta( $post_id, 'ghost_download_addlink', $links);
				}
			}
        $result['status'] 	= 1;
        $result['msg'] 	= '提交成功';
    }else{
        $result['status']	= 0;
        $result['msg'] 	= '提交失败';
    }
	echo json_encode( $result );
	exit;
}
add_action('wp_ajax_submit_addlink', 'submit_addlink');
add_action('wp_ajax_nopriv_submit_addlink', 'submit_addlink');

// 发布文章
function submit_mypost()
{
    global $wpdb,$current_user;
    $user_id = $current_user->ID;
    if(!is_user_logged_in()) exit;
		header( 'content-type: application/json; charset=utf-8' );
    if(empty($_POST['postmeta']['title'])){
        $result['status']	= 0;
        $result['msg'] 	= '请输入标题';
        echo json_encode( $result );exit;
    }
    if(empty($_POST['postmeta']['meta'])){
        $result['status']	= 0;
        $result['msg'] 	= '请输入内容';
        echo json_encode( $result );exit;
    }
    if(empty($_POST['postmeta']['cat'])){
        $result['status']	= 0;
        $result['msg'] 	= '请填写分类';
        echo json_encode( $result );exit;
    }
    if(empty($_POST['postmeta']['tag'])){
        $result['status']	= 0;
        $result['msg'] 	= '请输入标签';
        echo json_encode( $result );exit;
    }
	$title = trim(htmlspecialchars($_POST['postmeta']['title']));
    $meta = trim($_POST['postmeta']['meta']);
    $cat = (int)$_POST['postmeta']['cat'];
    $tag = $_POST['postmeta']['tag'];
    $links = $_POST['link'];
    $music = trim($_POST['music']);
    $video = trim($_POST['video']);
    $tag_ = implode(",", $tag);
	$post_email_msg = get_user_meta($user_id,'post_email_msg',true);
	$post_email_msg = isset($post_email_msg) ? $post_email_msg : ghost_get_option('post_email_msg');
    if(get_user_meta($user_id,'user_credit',true)>0){
        if($_POST['postmeta']['type']=='newpost'){
            $args = array(
                'post_title'    => $title,
                'post_content'  => $meta,
                'post_status'   => 'pending',
                'post_author'   => get_current_user_id(),
                'post_category' => array($cat),
                'tags_input'    => $tag_,
                'post_type' => 'post'
            );
            $post_id = wp_insert_post( $args);
            if(!empty($links)){
                update_post_meta( $post_id, 'ghost_download', $links );
            }
            if(!empty($video)){
                update_post_meta( $post_id, 'ghost_video', $video );
            }
            if(!empty($music)){
                update_post_meta( $post_id, 'ghost_music', $music );
            }
            $credit = ghost_update_user_credit($user_id,ghost_get_option('post_credit_msg'),'post');
            if($post_email_msg){
                sendMail($current_user->user_email, '发布文章', '您的文章发布成功，等待审核中！');
            }
            $result['status']	= 1;
            $result['url']	= get_permalink($post_id);
            $result['msg'] 	= '发布成功';
        }else if($_POST['postmeta']['type']=='updatepost'){
            $args = array(
                'ID'            => $_POST['postmeta']['post_id'],
                'post_title'    => $title,
                'post_content'  => $meta,
                'post_status'   => 'pending',
                'post_category' => array($cat),
                'tags_input'    => $tag_,
                'post_type' => 'post'
            );
            $post_id = wp_update_post( $args);
            if(!empty($links)){
                update_post_meta( $post_id, 'ghost_download', $links );
            }
            if(!empty($video)){
                update_post_meta( $post_id, 'ghost_video', $video );
            }
            if(!empty($music)){
                update_post_meta( $post_id, 'ghost_music', $music );
            }
            if($post_email_msg){
                sendMail($current_user->user_email, '更新文章', '您的文章更新成功，等待审核中！');
            }
            $result['status']	= 1;
            $result['url']	= get_permalink($post_id);
            $result['msg'] 	= '更新成功';
        }
    }else{
        $result['status']	= 0;
        $result['msg'] 	= '发布失败';
    }
	echo json_encode( $result );
	exit;	
}
add_action('wp_ajax_submit_mypost', 'submit_mypost');
add_action('wp_ajax_nopriv_submit_mypost', 'submit_mypost');


// 上传文章图片
function upload_post_pic()
{
    header('Content-type:application/json; Charset=utf-8');
    global $current_user;
    $uid = $current_user->ID;
    if(!is_user_logged_in()){ exit;}
    $file = !empty($_FILES['file']) ? $_FILES['file'] : null;
    if (is_uploaded_file($file['tmp_name']) && is_user_logged_in()) {
        $picname = $file['name'];
        $picsize = $file['size'];
        $arrType = array('image/jpg', 'image/gif', 'image/png', 'image/bmp', 'image/pjpeg', "image/jpeg");
        $rand    = (rand(10, 100));
        if ($picname != "") {
            if ($picsize > 1024*1024*ghost_get_option('pic_size')) {
                $result['code']	= 0;
                $result['message'] = '头像最大限制'.ghost_get_option('pic_size').'M';
            } elseif (!in_array($file['type'], $arrType)) {
                $result['code']	= 0;
                $result['message'] = '图片类型错误';
            } else {
                // 上传生成的海报图片至指定文件夹
                $upload_dir = wp_upload_dir();
                $upfile = $upload_dir['basedir'] . '/post_img/';
                if (!is_dir($upfile)) {
                    wp_mkdir_p($upfile);
                }

                if( ghost_get_option('ghost_oss')==true ){
                    // 上传文件到阿里云oss
                    $AliyunOss = new AliyunOss();
                    $res = upload_File($file,'post_img/'.$uid.'/'.date("Y").'/'.date("m"),$upfile,$uid);
                    $result = $AliyunOss->upload_file($res['dest'],$res['fname']);
    
                    if ($res) {
                        $result['code']	= 1;
                        $result['message'] = '上传成功';
                        $result['pic'] = $result['oss_file'];
                    } else {
                        $result['code']	= 0;
                        $result['message'] = '上传失败';
                    }
                }else{
                    //本低上传
                    $res = upload_File($file,'post_img/'.$uid.'/'.date("Y").'/'.date("m"),$upfile,$uid);
    
                    if ($res) {
                        $result['code']	= 1;
                        $result['message'] = '上传成功';
                        $result['pic'] = $upload_dir['baseurl'] . '/post_img/' . $res['file_name'];
                    } else {
                        $result['code']	= 0;
                        $result['message'] = '上传失败';
                    }
                }
            }
        }
    }else{
        $result['code']	= 0;
        $result['message'] = '文件错误';
    }
	echo json_encode( $result );
	exit;
}
add_action('wp_ajax_upload_post_pic', 'upload_post_pic');
add_action('wp_ajax_nopriv_upload_post_pic', 'upload_post_pic');

//时间转换
function ghost_date($ptime){
    $ptime = strtotime($ptime);
    $etime = time() - $ptime;
    if ($etime < 1) return '刚刚';     
    $interval = array (         
    12 * 30 * 24 * 60 * 60  =>  '年前',
    30 * 24 * 60 * 60       =>  '月前',
    7 * 24 * 60 * 60        =>  '周前',
    24 * 60 * 60            =>  '天前',
    60 * 60                 =>  '小时前',
    60                      =>  '分钟前',
    1                       =>  '秒前'
    );
    foreach ($interval as $secs => $str) {
    $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . $str;
        }
    };
}

// 添加用户粉丝
function ghost_update_user_fans($flowerid,$fans){
    if($flowerid){
        global $wpdb;
        $table_name=$wpdb->prefix.'ghost_fans';
        $time=current_time('mysql');
        $wpdb->query( "INSERT INTO $table_name (user_id,fans_id,fans_time,status) VALUES ('$flowerid','$fans','$time',1)" );
    }
}

// 删除用户粉丝
function ghost_del_user_fans($flowerid,$fans){
    if($flowerid){
        global $wpdb;
        $table_name=$wpdb->prefix.'ghost_fans';
        $time=current_time('mysql');
        $wpdb->query( "DELETE FROM $table_name WHERE fans_id=$fans " );
    }
}

// 关注
function ajax_flowers()
{
    header('Content-type:application/json; Charset=utf-8');
    global $current_user,$wpdb;
    $fans = $current_user->ID;
    $flowerid = !empty($_POST['flowerid']) ? $_POST['flowerid'] : null;
    if(!is_user_logged_in()){ exit;}
    if($flowerid){
        $request = "SELECT fans_id FROM wp_ghost_fans WHERE fans_id=$fans";
        $fan = $wpdb->query($request);
        if($fan){
            $result['status']	= 0;
            $result['msg'] = '已经关注';
        }else{
            if($fans!=$flowerid){
                ghost_update_user_fans($flowerid,$fans);
                ghost_update_user_credit($flowerid,ghost_get_option('flowers'));
                $credit = ghost_update_user_credit($fans,ghost_get_option('flowers'),'flowers',null,null,$flowerid,$fans);
                $result['status']	= 1;
                $result['msg'] = '关注成功';
            }else{
                $result['status']	= 0;
                $result['msg'] = '不能关注自己';
            }
        }
    }else{
        $result['status']	= 0;
        $result['msg'] = '关注失败';
    }

	echo json_encode( $result );
	exit;
}
add_action('wp_ajax_ajax_flowers', 'ajax_flowers');
add_action('wp_ajax_nopriv_ajax_flowers', 'ajax_flowers');

// 取消关注
function ajax_del_flowers()
{
    header('Content-type:application/json; Charset=utf-8');
    global $current_user,$wpdb;
    $fans = $current_user->ID;
    $flowerid = !empty($_POST['flowerid']) ? $_POST['flowerid'] : null;
    if(!is_user_logged_in()){ exit;}
    if($flowerid){
        $request = "SELECT fans_id FROM wp_ghost_fans WHERE fans_id=$fans";
        $fan = $wpdb->query($request);
        if($fan){
            if($fans!=$flowerid){
                ghost_del_user_fans($flowerid,$fans);
                ghost_update_user_credit($flowerid,ghost_get_option('del_flowers'));
                $credit = ghost_update_user_credit($fans,ghost_get_option('del_flowers'),'del_flowers',null,null,$flowerid,$fans);
                $result['status']	= 1;
                $result['msg'] = '取关成功';
            }else{
                $result['status']	= 0;
                $result['msg'] = '不能取关自己';
            }
        }else{
            $result['status']	= 0;
            $result['msg'] = '已经取关';
        }
    }else{
        $result['status']	= 0;
        $result['msg'] = '取关失败';
    }

	echo json_encode( $result );
	exit;
}
add_action('wp_ajax_ajax_del_flowers', 'ajax_del_flowers');
add_action('wp_ajax_nopriv_ajax_del_flowers', 'ajax_del_flowers');

/**
 * [getTime 获取今天的开始和结束时间]
 * @Author   Dadong2g
 * @DateTime 2019-05-28T12:25:26+0800
 * @return   [type]                   [description]
 */
function getTime()
{
    $str          = date("Y-m-d", time()) . "0:0:0";
    $data["star"] = strtotime($str);
    $str          = date("Y-m-d", time()) . "24:00:00";
    $data["end"]  = strtotime($str);
    return $data;
}

// 签到
function ajax_sign_daily()
{
    header('Content-type:application/json; Charset=utf-8');
    global $current_user;
    $userid = $current_user->ID;
    if(!is_user_logged_in()){ exit;}
    $sign_daily = (get_user_meta($userid, 'sign_daily', true)) ? get_user_meta($userid, 'sign_daily', true) : 0;
    $getTime  = getTime();
    if($userid){
			//第一次进入,需要缓存
			// WP_User_Query参数
			$args = array (
			'meta_key' => 'sign_daily',
			'orderby' => 'meta_value_num',
			'order'	 => 'DESC',
			);

			$authors = get_users($args);

			$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
			$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
			if(!empty($authors)){
			foreach($authors as $author ){
			$times = !empty(get_user_meta($author->ID,'sign_daily',true)) ? ghost_date(date("Y-m-d H:i:s",get_user_meta($author->ID,'sign_daily',true))) : 0;
			$days = !empty(get_user_meta($author->ID,'sign_daily_num',true)) ? get_user_meta($author->ID,'sign_daily_num',true) : 0;
			$credit = !empty(get_user_meta($author->ID,'user_credit',true)) ? get_user_meta($author->ID,'user_credit',true) : 0;
			if( get_user_meta($author->ID,'sign_daily',true) > $beginToday && get_user_meta($author->ID,'sign_daily',true) < $endToday ){

				$result['name']=get_user_meta($author->ID,'nickname',true);
				$result['time']=date('Y-m-d H:i:s', get_user_meta($author->ID,'sign_daily',true));

			}
			}
			}
        if(!($getTime['star'] < $sign_daily && $getTime['end'] > $sign_daily)){
            $thenTime = time();
            update_user_meta($userid, 'sign_daily',$thenTime);
				if($sign_daily_num = get_user_meta($userid, 'sign_daily_num',true)){
            update_user_meta($userid, 'sign_daily_num',$sign_daily_num+1);
				}else{
            update_user_meta($userid, 'sign_daily_num',1);
				}
            $credit = ghost_update_user_credit($userid,ghost_get_option('ghost_sign_daily'),'sign_daily');
            $result['status']	= 1;
					$result['msg'] = '签到成功！获得'.ghost_get_option('ghost_sign_daily').'积分';
        }else{
            $result['status']	= 0;
            $result['msg'] = '已经签到';
        }
    }else{
        $result['status']	= 0;
        $result['msg'] = '签到失败';
    }

	echo json_encode( $result );
	exit;
}
add_action('wp_ajax_ajax_sign_daily', 'ajax_sign_daily');
add_action('wp_ajax_nopriv_ajax_sign_daily', 'ajax_sign_daily');


// 删除文章
function ajax_delete_post()
{
    header('Content-type:application/json; Charset=utf-8');
    global $current_user;
    $userid = $current_user->ID;
    if(!is_user_logged_in()){ exit;}
    if($userid && current_user_can('level_10')){
		wp_delete_post($_POST['post_id'],false);
		$result['status']	= 1;
		$result['msg'] = '删除成功';
    }else{
		$result['status']	= 0;
		$result['msg'] = '删除失败';
    }

	echo json_encode( $result );
	exit;
}
add_action('wp_ajax_ajax_delete_post', 'ajax_delete_post');
add_action('wp_ajax_nopriv_ajax_delete_post', 'ajax_delete_post');

// 挂件商城
function ajax_guajian_shop()
{
    header('Content-type:application/json; Charset=utf-8');
    global $current_user;
    $userid = $current_user->ID;
    if(!is_user_logged_in()){ exit;}
    $img = !empty($_POST['img']) ? $_POST['img'] : null;
    $month = !empty($_POST['month']) ? $_POST['month'] : 0;
    $credit = !empty(ghost_get_option('ghost_shop_guajian_month_credit')) ? ghost_get_option('ghost_shop_guajian_month_credit') : -10;
    if(isset($_POST['shop_guajian_']) && wp_verify_nonce( $_POST['shop_guajian_'], 'shop_guajian_' ) && isset( $_POST['shop_guajian_'] )){
		if(get_user_meta($userid,'user_credit',true)+$credit>0 && get_user_meta($userid,'user_credit',true)>0){
        if(get_user_meta( $userid, 'ghost_guajian', true )){
            $result['status']	= 0;
            $result['msg'] = '已经开通';
        }elseif($img && $credit && $month){
    		$credit = ghost_update_user_credit($userid,$month*$credit,'guajian',null,null,null,null);
    		update_user_meta( $userid, 'ghost_guajian', $img );
    		update_user_meta( $userid, 'ghost_guajian_time', date('Y-m-d H:i:s',strtotime('+'.$month.' month')) );
            $result['status']	= 1;
            $result['msg'] = '购买成功';
        }else{
            $result['status']	= 0;
            $result['msg'] = '未选择选项';
        }
		}else{
			$result['status']	= 0;
			$result['msg'] = '积分不足';
		}
    }else{
        $result['status']	= 0;
        $result['msg'] = '验证失败';
    }

	echo json_encode( $result );
	exit;
}
add_action('wp_ajax_ajax_guajian_shop', 'ajax_guajian_shop');
add_action('wp_ajax_nopriv_ajax_guajian_shop', 'ajax_guajian_shop');

// 答题结果
function dati_result()
{
	global $current_user;
	$user_id = $current_user->ID;
	$allnum = count(ghost_get_option( 'dati_add' ));
	$fenshu = 0;
	$data = date("Y-m-d h:i:sa");
	if(is_user_logged_in()){
			for($i=0;$i<$allnum;$i++){
				$num = $_POST['all_daan'][$i]['num'];
				$user_daan = $_POST['all_daan'][$i]['daan'];
				$daan = ghost_get_option( 'dati_add' )[$i]['ti_select_daan'];
				if($user_daan == $daan){
					$fenshu+=100/$allnum;
				}
			}
			if(is_super_admin()){
				$data_arr['code'] = 1;
				$data_arr['msg'] = '<div class="user_test_result"><div class="user_test_result_content">您已经是超级管理员了！</div><div class="user_test_result_content"><span>再来一次！</span></div></div>';
			}else{
				if ($fenshu>=ghost_get_option( 'ti_jige' )){
					//给注册用户赋予角色
					wp_update_user(
						array(
							'ID'       => $user_id,
							'role'    => 'vip'
						)
					);
					$fenshu = (int)$fenshu;
					update_user_meta($user_id,'answer_fenshu',$fenshu);
					$data_arr['code'] = 1;
					$data_arr['msg'] = '<div class="user_test_result"><div class="user_test_result_content">恭喜您,得分：'.$fenshu.'及格！</div><div class="user_test_result_content">成为了正式会员！</div><div class="user_test_result_content"><span>再来一次！</span></div></div>';
				}else{
					$data_arr['code'] = 0;
					$data_arr['msg'] = '<div class="user_test_result"><div class="user_test_result_content">很抱歉，您'.number_format($fenshu,1).'分，不及格</div><div class="user_test_result_content"><span>再来一次！</span></div></div>';
				}
			}
	}else{
		$data_arr['code'] = 0;
		$data_arr['msg'] = '<div class="verify-step-1"><div class="verify-content box">
		<div class="verify-desc">未登录
		</div></div>
	   </div>';
	}

	header('content-type:application/json');
	echo json_encode($data_arr);
	exit;
}
add_action('wp_ajax_dati_result', 'dati_result');
add_action('wp_ajax_nopriv_dati_result', 'dati_result');

// 挂件切换
function ajax_guajian_shop_change()
{
    header('Content-type:application/json; Charset=utf-8');
    global $current_user;
    $userid = $current_user->ID;
    if(!is_user_logged_in()){ exit;}
    $img = !empty($_POST['img']) ? $_POST['img'] : null;
	if($img && get_user_meta( $userid, 'ghost_guajian', true ) && strtotime(get_user_meta( $userid, 'ghost_guajian_time', true ))>strtotime(date('y-m-d h:i:s'))){
		update_user_meta( $userid, 'ghost_guajian', $img );
		$result['status']	= 1;
		$result['msg'] = '切换成功';
	}else{
		$result['status']	= 0;
		$result['msg'] = '切换失败';
	}

	echo json_encode( $result );
	exit;
}
add_action('wp_ajax_ajax_guajian_shop_change', 'ajax_guajian_shop_change');
add_action('wp_ajax_nopriv_ajax_guajian_shop_change', 'ajax_guajian_shop_change');


/**
* 修改url重写后的作者存档页的链接变量
*/
add_filter('author_link', 'author_link', 10, 2);
function author_link( $link, $author_id) {
    global $wp_rewrite;
    $author_id = (int) $author_id;
    $link = $wp_rewrite->get_author_permastruct();
    if ( empty($link) ) {
        $file = home_url( '/' );
        $link = $file . '?author=' . $author_id;
    } else {
        $link = str_replace('%author%', $author_id, $link);
        $link = home_url( user_trailingslashit( $link ) );
    }
    return $link;
}
/**
* 替换作者的存档页的用户名，防止被其他用途
* 作者存档页链接有2个查询变量，
* 一个是author（作者用户id），用于未url重写
* 另一个是author_name（作者用户名），用于url重写
* 此处做的是，在url重写之后，把author_name替换为author
*/
add_filter('request', 'author_link_request');
function author_link_request( $query_vars ) {
    if ( array_key_exists( 'author_name', $query_vars ) ) {
        global $wpdb;
        $author_id=$query_vars['author_name'];
        if ( $author_id ) {
            $query_vars['author'] = $author_id;
            unset( $query_vars['author_name'] );    
        }
    }
    return $query_vars;
}