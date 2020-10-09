<?php
add_filter( 'password_change_email', '__return_false' );//关闭密码修改用户邮件
add_filter( 'wp_new_user_notification_email_admin', '__return_false' );//关闭新用户注册站长邮件
add_filter( 'wp_new_user_notification_email', '__return_false' );//关闭新用户注册用户邮件

//自定义head钩子
function ghost_head(){
do_action('ghost_head');
}

/**
* 完全禁用wp-json
*/
function lerm_disable_rest_api( $access ) {
	return new WP_Error(
		'Stop!',
		'这里什么也没有！',
		array(
			'status' => 403,
		)
	);
}
add_filter( 'rest_authentication_errors', 'lerm_disable_rest_api' );
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );

//wordpress后台禁用谷歌的字体api
class Uctheme_Disable_Google_Fonts {
public function __construct() {
add_filter( 'gettext_with_context', array( $this, 'disable_open_sans' ), 888, 4 );
}
public function disable_open_sans( $translations, $text, $context, $domain ) {
if ( 'Open Sans font: on or off' == $context && 'on' == $text ) {
$translations = 'off';
}
return $translations;
}
}
$disable_google_fonts = new Uctheme_Disable_Google_Fonts;

// 禁止谷歌字体
function remove_open_sans() {
wp_deregister_style( 'open-sans' );
wp_register_style( 'open-sans', false );
wp_enqueue_style('open-sans','');
}
add_action( 'init', 'remove_open_sans' );

//移除wordpress自带功能
remove_action ('wp_head', 'wp_site_icon', 99);
remove_action( 'wp_head', 'feed_links', 2 ); //移除feed
remove_action( 'wp_head', 'feed_links_extra', 3 ); //移除feed
remove_action( 'wp_head', 'rsd_link' ); //移除离线编辑器开放接口
remove_action( 'wp_head', 'wlwmanifest_link' );  //移除离线编辑器开放接口
remove_action( 'wp_head', 'index_rel_link' );//去除本页唯一链接信息
remove_action('wp_head', 'parent_post_rel_link', 10, 0 );//清除前后文信息
remove_action('wp_head', 'start_post_rel_link', 10, 0 );//清除前后文信息
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'wp_generator' ); //移除WordPress版本
remove_action( 'wp_head', 'rel_canonical' );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
remove_action( 'template_redirect', 'wp_shortlink_header', 11, 0 );
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'wp_head', 'oembed_discovery_links', 10 );

remove_action( 'admin_print_scripts', 'print_emoji_detection_script');
remove_action( 'admin_print_styles', 'print_emoji_styles');
remove_action( 'wp_head', 'print_emoji_detection_script', 7);
remove_action( 'wp_print_styles', 'print_emoji_styles');
remove_filter( 'the_content_feed', 'wp_staticize_emoji');
remove_filter( 'comment_text_rss', 'wp_staticize_emoji');
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email');
remove_action('wp_head','wp_resource_hints',2);
//移除自带的小工具
function ghost_remove_widget() {
  unregister_widget('WP_Widget_Pages');
  unregister_widget('WP_Widget_Calendar');
  unregister_widget('WP_Widget_Archives');
  unregister_widget('WP_Widget_Links');
  unregister_widget('WP_Widget_Meta');
  unregister_widget('WP_Widget_Search');
  unregister_widget('WP_Widget_Categories');
  unregister_widget('WP_Widget_Recent_Posts');
  unregister_widget('WP_Widget_Recent_Comments');
  unregister_widget('WP_Widget_RSS');
  unregister_widget('WP_Widget_Tag_Cloud');
  unregister_widget('WP_Nav_Menu_Widget');
  unregister_widget('WP_Widget_Media_Audio');
  unregister_widget('WP_Widget_Media_Image');
  unregister_widget('WP_Widget_Media_Video');
  unregister_widget('WP_Widget_Custom_HTML');
  unregister_widget('WP_Widget_Text');
  unregister_widget('WP_Widget_Media_Gallery');
  }
add_action( 'widgets_init', 'ghost_remove_widget',11 );

//注册菜单功能

register_nav_menus(array('menu-pc' => '电脑菜单栏'));
function ghost_pc_search_(){
  $html='';
  foreach(ghost_get_option('ghost_pc_search') as $value){
    $html.='<a class="search_bar_item">'.$value['ghost_pc_search_word'].'</a>';
  }
  return $html;
}

function mypost_cat(){
  $html='';
  global $wpdb;
  $request = "SELECT $wpdb->terms.term_id, name FROM $wpdb->terms ";
  $request .= " LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id ";
  $request .= " WHERE $wpdb->term_taxonomy.taxonomy = 'category' AND $wpdb->term_taxonomy.parent = 0 ";
  $request .= " ORDER BY term_id asc";
  $categorys = $wpdb->get_results($request);
              
  foreach ($categorys as $category) { //调用菜单
    $html.='<div class="ghost_post_category_item">';
    if(wp_get_term_taxonomy_parent_id(get_cat_ID($category->name),'category')==0){
      $html.= '<a data-catid="'.get_cat_ID($category->name).'" class="ghost_post_category_item_link is-parent">'.$category->name.'</a>';
    }
    $id=get_cat_ID($category->name);
    $request_child = "SELECT $wpdb->terms.term_id, name FROM $wpdb->terms LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id WHERE $wpdb->term_taxonomy.taxonomy = 'category' AND $wpdb->term_taxonomy.parent = $id ORDER BY term_id asc";
    $categorys_child = $wpdb->get_results($request_child);
    $html.= '<div class="ghost_post_category_item_children">';
    foreach ($categorys_child as $category_child) { //调用菜单
        $html.='<a data-catid="'.get_cat_ID($category_child->name).'" class="ghost_post_category_item_link is-child">'.$category_child->name.'</a>';
    }
    $html .= '</div>';
    $html.='</div>';
  }
  return $html;
}

function ghost_script_parameter(){
  global $current_user;
  $ghost=array();
  $ghost['userlogin_security_nonce'] = wp_create_nonce( 'userlogin_security_nonce' );
  $ghost['userreg_security_nonce'] = wp_create_nonce( 'userreg_security_nonce' );
  $ghost['userforget_security_nonce'] = wp_create_nonce( 'userforget_security_nonce' );
  $ghost['comment_security_nonce'] = wp_create_nonce( 'comment_security_nonce' );
  $ghost['report_security_nonce'] = wp_create_nonce( 'report_security_nonce' );
  $ghost['shop_guajian_'] = wp_create_nonce( 'shop_guajian_' );
  $ghost['ajaxurl'] = admin_url('admin-ajax.php');
  $ghost['ghost_ajax'] = get_template_directory_uri();
  $ghost['siteurl'] = get_bloginfo('url');
  $ghost['title'] = my_title();
  $ghost['user_limit'] = ( is_user_logged_in() && (current_user_can( 'svip' ) || current_user_can( 'vip' ) || current_user_can( 'manage_options' ) )) ? true : false;
  $ghost['login_news'] = ghost_get_option('login_news');
  $ghost['ghost_pc_search'] = ghost_pc_search_();
	if(get_query_var('ghost_page_type')=='newpost' || get_query_var('ghost_page_type')=='edit_post'){
	  $ghost['mypost_cat'] = mypost_cat();
	}
  $ghost['dati_length'] = count(ghost_get_option( 'dati_add' )) ? count(ghost_get_option( 'dati_add' )) : 0;
  $ghost_shop_guajian_month_credit = ghost_get_option('ghost_shop_guajian_month_credit');
  $ghost['shop_guajian_credit'] = isset($ghost_shop_guajian_month_credit) ? $ghost_shop_guajian_month_credit : 10;
  $ghost['ghost_sign_url'] = ghost_get_option('ghost_sign_url');
  $ghost['post_link_max_credit'] = ghost_get_option('post_link_max_credit') ? ghost_get_option('post_link_max_credit') : 20;
  $object_json = json_encode($ghost);
  return $object_json;
}
//加载js和css
function ghost_load_scripts(){
	wp_dequeue_style( 'wp-block-library' );
	wp_deregister_script('jquery');
  if(ghost_get_option('open_cdn_url')==true){
    $assets_url=ghost_get_option('my_cdn_url');
  }else{
    $assets_url=get_template_directory_uri();
  }
  $vision = '1.0.0';
  wp_enqueue_script('jquery',$assets_url.'/assets/js/jquery-3.5.1.min.js',$vision,1);
  wp_enqueue_script('ghostjs',$assets_url.'/assets/js/ghost.js',$vision,3);
  wp_enqueue_script('lazyloadjs',$assets_url.'/assets/js/jquery.lazyload.min.js',$vision,7);//懒加载图片
  wp_enqueue_script('easingjs',$assets_url.'/assets/js/jquery.easing.js',$vision,9);//返回顶部动画
  wp_enqueue_script('tinymcejs',$assets_url.'/assets/tinymce/tinymce.min.js');//编辑器
//   wp_enqueue_script('DPlayer',$assets_url.'/assets/DPlayer/dist/DPlayer.min.js');//DPlayer
  wp_enqueue_script('APlayer',$assets_url.'/assets/APlayer/dist/APlayer.min.js');//aplayer
  wp_enqueue_style('APlayer',$assets_url.'/assets/APlayer/dist/APlayer.min.css',$vision,4);//aplayer
  wp_enqueue_style('bootstrap',$assets_url.'/assets/css/bootstrap.min.css',$vision,4);
  wp_enqueue_style('ghostcss',$assets_url.'/assets/css/ghost.css',$vision,5);
  wp_enqueue_style('fontawesome','https://cdn.bootcdn.net/ajax/libs/font-awesome/5.13.0/css/all.min.css',$vision,6);//真棒图标
?>
<style>
:root {
	--box-shadow: <?php echo ghost_get_option('box-shadow') ?>;
	--box-shadow-hover: <?php echo ghost_get_option('box-shadow-hover') ?>;
	--site-color-tag: <?php echo ghost_get_option('site-color-tag') ?>;
	--site-color: <?php echo ghost_get_option('site-color') ?>;
	--site-background-hover: <?php echo ghost_get_option('site-background-hover') ?>;
	--site-background-bg: <?php echo ghost_get_option('site-background-bg') ?>;
}
</style>
<script type="text/javascript">
  var ghost = <?php echo ghost_script_parameter();?>;
</script>
<?php
}
add_action('wp_enqueue_scripts','ghost_load_scripts');

//加载js和css
function ghost_load_footer_scripts(){
  if(ghost_get_option('open_cdn_url')==true){
    $assets_url=ghost_get_option('my_cdn_url');
  }else{
    $assets_url=get_template_directory_uri();
  }
  $vision = '1.0.0';
  wp_enqueue_script('footerjs',$assets_url.'/assets/js/footer.js',$vision,3);
  wp_enqueue_script('fancyboxjs','https://cdn.staticfile.org/fancybox/3.5.7/jquery.fancybox.min.js',$vision,3);
  wp_enqueue_style('fancybox','https://cdn.staticfile.org/fancybox/3.5.7/jquery.fancybox.min.css',$vision,4);//aplayer
}
add_action( 'wp_footer', 'ghost_load_footer_scripts', 1 );

//注册数据库表
function ghost_table_install(){
  global $wpdb;
  require_once(ABSPATH.'wp-admin/includes/upgrade.php'); 
  $table_name_fans = $wpdb->prefix . 'ghost_fans';   
  if( $wpdb->get_var("SHOW TABLES LIKE '$table_name_fans'") != $table_name_fans ){
  $sql_fans = " CREATE TABLE `$table_name_fans` (
  `ID` int NOT NULL AUTO_INCREMENT, 
  PRIMARY KEY(ID),
  `user_id` int,
  `fans_id` int,
  `fans_time` datetime,
  `status` int
  ) ENGINE = MyISAM CHARSET=utf8;";
  dbDelta($sql_fans);
  }
  
  $table_name_msg = $wpdb->prefix . 'ghost_msg';
  if( $wpdb->get_var("SHOW TABLES LIKE '$table_name_msg'") != $table_name_msg ){
  $sql_msg = " CREATE TABLE `$table_name_msg` (
  `ID` int NOT NULL AUTO_INCREMENT, 
  PRIMARY KEY(ID),
  `user_id` int,
  `target_id` int,
  `msg_type` text,
  `msg_credit` int,
  `msg_time` datetime,
  `post_id` int,
  `commentid` int,
  `flower_id` int,
  `fans_id` int,
  `status` int
  ) ENGINE = MyISAM CHARSET=utf8;";
  dbDelta($sql_msg);
  }

  $table_name_comment_like = $wpdb->prefix . 'ghost_comment_like';
  if( $wpdb->get_var("SHOW TABLES LIKE '$table_name_comment_like'") != $table_name_comment_like ){
  $sql_comment_like = " CREATE TABLE `$table_name_comment_like` (
  `ID` int NOT NULL AUTO_INCREMENT, 
  PRIMARY KEY(ID),
  `comment_id` int,
  `user_id` int,
  `status` int
  ) ENGINE = MyISAM CHARSET=utf8;";
  dbDelta($sql_comment_like);
  }

  $table_name_message = $wpdb->prefix . 'ghost_message';
  if( $wpdb->get_var("SHOW TABLES LIKE '$table_name_message'") != $table_name_message ){
  $sql_message = " CREATE TABLE `$table_name_message` (
  `ID` int NOT NULL AUTO_INCREMENT, 
  PRIMARY KEY(ID),
  `user_id` int,
  `from_id` int,
  `type` text,
  `msg_time` datetime,
  `content_type` text,
  `user_read` int,
  `from_read` int,
  `status` int
  ) ENGINE = MyISAM CHARSET=utf8;";
  dbDelta($sql_message);
  }
	
  $table_name_ip = $wpdb->prefix . 'ghost_ip';
  if( $wpdb->get_var("SHOW TABLES LIKE '$table_name_ip'") != $table_name_ip ){
  $sql_ip = " CREATE TABLE `$table_name_ip` (
  `ID` int NOT NULL AUTO_INCREMENT, 
  PRIMARY KEY(ID),
  `type` text,
  `user_id` int,
  `post_id` int,
  `ip` text,
  `msg_time` datetime
  ) ENGINE = MyISAM CHARSET=utf8;";
  dbDelta($sql_ip);
  }

  $table_name_report = $wpdb->prefix . 'ghost_report';
  if( $wpdb->get_var("SHOW TABLES LIKE '$table_name_report'") != $table_name_report ){
  $sql_report = " CREATE TABLE `$table_name_report` (
  `ID` int NOT NULL AUTO_INCREMENT, 
  PRIMARY KEY(ID),
  `type` text,
  `user_id` int,
  `post_id` int,
  `container` text,
  `msg_time` datetime
  ) ENGINE = MyISAM CHARSET=utf8;";
  dbDelta($sql_report);
  }
}
add_action( 'after_switch_theme', 'ghost_table_install' );

// 添加菜单真棒图标输入框
// 感谢大佬的代码
/**
* Add custom fields to menu item
*
* This will allow us to play nicely with any other plugin that is adding the same hook
*
* @param  int $item_id 
* @params obj $item - the menu item
* @params array $args
*/
function kia_custom_fields( $item_id, $item ) {

	wp_nonce_field( 'custom_menu_meta_nonce', 'custom_menu_tubiao_nonce_name' );
	$custom_menu_meta = get_term_meta( $item_id, 'custom_menu_tubiao', true );
	?>

	<input type="hidden" name="custom-menu-meta-nonce" value="<?php echo wp_create_nonce( 'custom-menu-meta-name' ); ?>" />

	<div class="field-custom_menu_meta description-wide" style="margin: 5px 0;">
	    <span class="description"><?php _e( "菜单图标", 'custom-menu-meta' ); ?></span>
	    <br />

	    <input type="hidden" class="nav-menu-id" value="<?php echo $item_id ;?>" />

	    <div class="logged-input-holder">
	        <input type="text" name="custom_menu_meta[<?php echo $item_id ;?>]" id="custom-menu-meta-for-<?php echo $item_id ;?>" value="<?php echo esc_attr( $custom_menu_meta ); ?>" />
	        <label for="custom-menu-meta-for-<?php echo $item_id ;?>">
	            <?php _e( '请输入真棒图标，如：fa-video', 'custom-menu-meta'); ?>
	        </label>
	    </div>

	</div>

	<?php
}
add_action( 'wp_nav_menu_item_custom_fields', 'kia_custom_fields', 10, 2 );
/**
* Save the menu item meta
* 
* @param int $menu_id
* @param int $menu_item_db_id	
*/
function kia_nav_update( $menu_id, $menu_item_db_id ) {

	// Verify this came from our screen and with proper authorization.
	if ( ! isset( $_POST['custom_menu_tubiao_nonce_name'] ) || ! wp_verify_nonce( $_POST['custom_menu_tubiao_nonce_name'], 'custom_menu_meta_nonce' ) ) {
		return $menu_id;
	}

	if ( isset( $_POST['custom_menu_meta'][$menu_item_db_id]  ) ) {
		$sanitized_data = sanitize_text_field( $_POST['custom_menu_meta'][$menu_item_db_id] );
		update_term_meta( $menu_item_db_id, 'custom_menu_tubiao', $sanitized_data );
	} else {
		delete_term_meta( $menu_item_db_id, 'custom_menu_tubiao' );
	}
}
add_action( 'wp_update_nav_menu_item', 'kia_nav_update', 10, 2 );

// 强化菜单 代表时间
// 一日 today
// 一周 1 week ago
// 一年 1 year ago
// 千年 1000 year ago
function get_this_week_post_count_by_category($id) {
	$date_query = array(
		array(
			'after' => '3 year ago'
			)
		);
	$tax_query = array(
		array(
			'taxonomy' => 'category',
				'field' => 'id',
				'terms' => $id
			)
		);
	$args = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'tax_query' => $tax_query,
		'date_query' => $date_query,
		'no_found_rows' => true,
		'suppress_filters' => true,
		'fields' => 'ids',
		'posts_per_page' => -1
		);
	$query = new WP_Query( $args );
	return $query->post_count;
}

/**
* Displays text on the front-end.
*
* @param string   $title The menu item's title.
* @param WP_Post  $item  The current menu item.
* @return string      
*/
function kia_custom_menu_title( $title, $item ) {
	if( is_object( $item ) && isset( $item->ID ) ) {

    $custom_menu_meta = get_term_meta( $item->ID, 'custom_menu_tubiao', true );
    
		if ( ! empty( $custom_menu_meta ) ) {
			$title = '<i class="catacg-mune-tubiao fas '.$custom_menu_meta.'"> </i>'.$item->title.'<i class="ghost-menu-posts-count" title="本周发布的">'.get_this_week_post_count_by_category($item->object_id).'</i>';
		}
	}
	return $title;
}
add_filter( 'nav_menu_item_title', 'kia_custom_menu_title', 10, 2 );

add_filter('wp_nav_menu_items', 'add_new_menu_item', 1, 10);
function add_new_menu_item( $nav, $args ) {
    if(!wp_is_mobile()){
        $newmenuitem = '<li><a href="'.get_bloginfo('url').'" style="padding: 10px 15px 10px 10px;font-size: 25px;"><i class="catacg-mune-tubiao fas fa-home"> </i></a></li>';
        $nav = $newmenuitem.$nav;
    }
    return $nav;
}

// 修改用户权限名称
//WordPress删除用户角色
function wps_remove_role() {
    remove_role( 'contributor' );
    remove_role( 'subscriber' );
    remove_role( 'author' );
    remove_role( 'editor' );
}
add_action( 'init', 'wps_remove_role' );
//WordPress添加用户角色
function tp_add_role() {
    add_role('visitor', '游客', array(
		  'read' => true, //阅读权限，true表示允许
		  'upload_files' => true, //上传权限，true表示允许
		  'edit_posts' => false,//编辑文章的权限，true为允许
		  'delete_posts' => false, //删除文章的权限，false表示不允许删除
			'level_0'=>true
		));
		add_role('vip', '正式会员', array(
		  'read' => true, //阅读权限，true表示允许
		  'upload_files' => true, //上传权限，true表示允许
		  'edit_posts' => true,//编辑文章的权限，true为允许
		  'delete_posts' => false, //删除文章的权限，false表示不允许删除
			'level_1'=>true
		));
		add_role('svip', '大会员', array(
		  'read' => true, //阅读权限，true表示允许
		  'upload_files' => true, //上传权限，true表示允许
		  'edit_posts' => true,//编辑文章的权限，true为允许
		  'delete_posts' => false, //删除文章的权限，false表示不允许删除
			'level_1'=>true
		));
}
add_action( 'admin_init', 'tp_add_role' );

// 禁止非管理员登录后台
add_action('admin_init', 'redirect_non_admin_users');
function redirect_non_admin_users() {
  if (!current_user_can( 'administrator' ) && empty($_REQUEST)) {
    wp_redirect(home_url());
    exit;
  }
}

// 后台登陆地址
add_action('login_enqueue_scripts','login_protection');
function login_protection(){
    if($_GET['user'] != 'sdtclass')  header('Location: /');
}

// 退出登陆跳转链接
// add_filter('logout_url', 'ludou_logout_redirect', 10, 2);
// function ludou_logout_redirect($logouturl, $redir) {
// $redir = get_bloginfo('url'); // 这里改成你要跳转的网址
// return $logouturl . '&redirect_to='.urlencode($redir);
// }

// 获取视频封面
function convertToFlv( $input, $output ) {
  echo "Converting $input to $output<br />";
  $command = "ffmpeg -v 0 -y -i $input -vframes 1 -ss 5 -vcodec mjpeg -f rawvideo -s 286x160 -aspect 16:9 $output ";
  echo "$command<br />";
  shell_exec( $command );
  echo "Converted<br />";
}

//删除仪表盘

function disable_dashboard_widgets() {
  global $wp_meta_boxes;
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
}
add_action('wp_dashboard_setup', 'disable_dashboard_widgets', 999);

/* 移除WordPress后台底部左文字 */
add_filter('admin_footer_text', '_admin_footer_left_text');
function _admin_footer_left_text($text) {
   $text = '';
   return $text;
}
/* 移除WordPress后台底部右文字 */
add_filter('update_footer', '_admin_footer_right_text', 11);
function _admin_footer_right_text($text) {
   $text = '';
   return $text;
}
/*移除后台左上角logo信息*/
function _admin_bar_remove() {
       global $wp_admin_bar;
       // var_dump($wp_admin_bar);
       $wp_admin_bar->remove_menu('wp-logo');
       $wp_admin_bar->remove_menu('comments');
       $wp_admin_bar->remove_menu('new-page');
}   
add_action('wp_before_admin_bar_render', '_admin_bar_remove', 0);

// 删除磁力链接前缀
function ss_allow_magnet_protocol( $protocols ){
    $protocols[] = 'magnet';
    return $protocols;
}
function ss_allow_ed2k_protocol( $protocols ){
    $protocols[] = 'ed2k';
    return $protocols;
}
add_filter( 'kses_allowed_protocols' , 'ss_allow_magnet_protocol' );
add_filter( 'kses_allowed_protocols' , 'ss_allow_ed2k_protocol' );

// 添加额外的栏目  
add_filter('manage_users_columns', 'add_user_additional_column');  
function add_user_additional_column($columns) {  
  $columns['user_nickname'] = '昵称';  
//   $columns['user_url'] = '网站';    
  $columns['user_credit'] = '积分';  
  $columns['reg_time'] = '注册时间';  
  $columns['ua'] = 'ua设备';
  $columns['last_login'] = '上次登录';  
  // 打算将注册IP和注册时间、登录IP和登录时间合并显示，所以我注销下面两行  
  /*$columns['signup_ip'] = '注册IP';*/ 
  $columns['last_login_ip'] = '登录IP';  
  unset($columns['name']);//移除“姓名”这一栏，如果你需要保留，删除这行即可  
  //unset($columns['role']);//移除“角色”这一栏，
  return $columns;  
}  
//显示栏目的内容
add_action('manage_users_custom_column',  'show_user_additional_column_content', 10, 3);  
function show_user_additional_column_content($value, $column_name, $user_id) {  
  $user = get_userdata( $user_id );  
  // 输出“昵称”  
  if ( 'user_nickname' == $column_name )  
      return $user->nickname;  
  // 输出用户的网站  
  if ( 'user_credit' == $column_name )  
      return $user->user_credit;  
  // 输出注册时间和注册IP  
  if('reg_time' == $column_name ){  
      return get_date_from_gmt($user->user_registered) ;  
  }  
// 输出注册时间和注册IP  
  if('ua' == $column_name ){  
	  $html = '';
	  foreach (get_user_meta( $user_id, 'session_tokens', true ) as $index => $value) {
        $html .= $value['ua'].'<br>';
    }
      return $html;
  }  
  // 输出最近登录时间和登录IP  
  if ( 'last_login' == $column_name && $user->last_login ){  
	  $html = '';
	  foreach (get_user_meta( $user_id, 'session_tokens', true ) as $index => $value) {
        $html .= date("Y-m-d H:i:s",$value['login']).'<br>';
    }
      return $html;
  }   
// 输出最近登录时间和登录IP  
  if ( 'last_login_ip' == $column_name ){  
	  $html = '';
	  foreach (get_user_meta( $user_id, 'session_tokens', true ) as $index => $value) {
        $html .= $value['ip'].'<br>';
    }
      return $html;
  }  
  return $value;  
}  

// 调整样式 -黑鸟博客
function guihet_column_width() {
  echo '<style type="text/css">';
  echo '.column-last_login_ip .column-last_login{ text-align: center !important; width:90px;}';
  echo '</style>';
}
add_action('admin_head', 'guihet_column_width');


add_filter('get_avatar', 'MBT_get_avatar', 10, 3);
function MBT_get_avatar($avatar, $id_or_email, $size){
 $default_avatar = get_bloginfo('template_url').'/img/avatar.png'; //默认头像
 if(is_object($id_or_email)) {
 if($id_or_email->user_id != 0) {
 $email = $id_or_email->user_id;
 $user = get_user_by('email',$email);
 $user_avatar = get_user_meta($id_or_email->user_id, 'ghost_user_avatar', true);
 if($user_avatar)
 return '<img src="'.$user_avatar.'" class="avatar avatar-'.$size.' photo" width="'.$size.'" height="'.$size.'" alt="'.$user->display_name .'" />';
 else
 return '<img src="'.$default_avatar.'" class="avatar avatar-'.$size.' photo" width="'.$size.'" height="'.$size.'" alt="'.$user->display_name .'" />';
 
 }elseif(!empty($id_or_email->comment_author_email)) {
 //$user = get_user_by('email', $id_or_email->comment_author_email);
 //$email = !empty($user) ? $user->ID : $id_or_email->comment_author_email;
 return '<img src="'.$default_avatar.'" class="avatar avatar-'.$size.' photo" width="'.$size.'" height="'.$size.'" alt="'.$user->display_name .'" />';
 }
 }else{
 if(is_numeric($id_or_email) && $id_or_email > 0){
 $user = get_user_by('id',$id_or_email);
 $user_avatar = get_user_meta($id_or_email, 'ghost_user_avatar', true);
 if($user_avatar)
 return '<img src="'.$user_avatar.'" class="avatar avatar-'.$size.' photo" width="'.$size.'" height="'.$size.'" alt="'.$user->display_name .'" />';
 else
 return '<img src="'.$default_avatar.'" class="avatar avatar-'.$size.' photo" width="'.$size.'" height="'.$size.'" alt="'.$user->display_name .'" />';
 }elseif(is_email($id_or_email)){
 $user = get_user_by('email',$id_or_email);
 $user_avatar = get_user_meta($user->ID, 'ghost_user_avatar', true);
 if($user_avatar)
 return '<img src="'.$user_avatar.'" class="avatar avatar-'.$size.' photo" width="'.$size.'" height="'.$size.'" alt="'.$user->display_name .'" />';
 else
 return '<img src="'.$default_avatar.'" class="avatar avatar-'.$size.' photo" width="'.$size.'" height="'.$size.'" alt="'.$user->display_name .'" />';
 }else{
 return '<img src="'.$default_avatar.'" class="avatar avatar-'.$size.' photo" width="'.$size.'" height="'.$size.'" alt="" />';
 }
 }
 return $avatar;
}



// 添加后台界面meta_box
add_action('add_meta_boxes','ghost_seo_post_metas_box_init');
function ghost_seo_post_metas_box_init(){
	add_meta_box('seo-metas','SEO','ghost_seo_post_metas_box',array('post','page'),'side','high');
}
function ghost_seo_post_metas_box($post){
		$post_id = $post->ID;
	?>
	<div class="seo-metas">
        <p>SEO标题：<input type="text" class="regular-text" name="seo_title" value="<?php echo get_post_meta($post_id,'ghost_seo_title',true); ?>" style="max-width: 98%;"></p>
		<p>SEO关键词：<input type="text" class="regular-text" name="seo_keywords" value="<?php echo get_post_meta($post_id,'ghost_seo_keywords',true); ?>" style="max-width: 98%;"></p>
		<p>SEO描述：<br><textarea class="large-text" name="seo_description"><?php echo get_post_meta($post_id,'ghost_seo_description',true); ?></textarea></p>
		<p>若不指定，则自动使用文章标签作为关键词，文章前20个字符作为描述，若要取消，请直接设置成空格然后保存。</p>
	</div>
<?php
}

// 保存填写的meta信息
add_action('save_post','ghost_seo_post_metas_box_save');
function ghost_seo_post_metas_box_save($post_id){
    if(!isset($_POST['seo_title']) || !isset($_POST['seo_keywords']) || !isset($_POST['seo_description'])) return $post_id;
    $seo_title = strip_tags($_POST['seo_title']);
	$seo_keywords = strip_tags($_POST['seo_keywords']);
	$seo_description = stripslashes(strip_tags($_POST['seo_description']));
    if($seo_title == ' '){
        delete_post_meta($post_id,'ghost_seo_title');
    }elseif($seo_title){
        update_post_meta($post_id,'ghost_seo_title',$seo_title);
    }
	if($seo_keywords == ' '){
		delete_post_meta($post_id,'ghost_seo_keywords');
	}elseif($seo_keywords){
		update_post_meta($post_id,'ghost_seo_keywords',$seo_keywords);
	}

	if($seo_description == ' '){
		delete_post_meta($post_id,'ghost_seo_description');
	}elseif($seo_description){
		update_post_meta($post_id,'ghost_seo_description',$seo_description);
	}
}

//文章
function ghost_admin_post_column($value){
$newcolumns = array(
'cb' => '<input id="cb-select-all-1" type="checkbox">',
'title' => '标题',
'post_id' => '文章ID',
'author' =>'作者',
'categories' => __('分类/论坛'),
'tags' => '话题',
'type' => '类型',
'comments' => '评论',
'date' => '日期',
);
return $newcolumns;
// unset($value['comments']);
}
add_filter('manage_posts_columns','ghost_admin_post_column');

function ghost_admin_add_post_columns($column,$post_id){
if($column==='post_id'){
echo $post_id;
}else if($column==='type'){
$video_urls=json_decode(get_post_meta($post_id,'ghost_video',true));
$music_urls=json_decode(get_post_meta($post_id,'ghost_music',true));
	if($video_urls){
		echo '视频';
	}elseif($music_urls){
		echo '音乐';
	}else{
		echo '文章';
	}
}
}
add_action('manage_posts_custom_column','ghost_admin_add_post_columns',5,2);

