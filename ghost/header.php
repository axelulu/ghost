<?php global $current_user;$user_id = $current_user->ID;
$menu_category_id = get_query_var('cat') ? get_query_var('cat') : '';
$menu = get_redis('menu'.$menu_category_id,'menu');
?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
		<meta http-equiv="Cache-Control" content="no-transform">
		<meta http-equiv="Cache-Control" content="no-siteapp">
		<meta name="renderer" content="webkit">
		<meta name="force-rendering" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php wp_head();?>
		<?php if(is_single()){ ?>
		<script src="https://cdn.bootcdn.net/ajax/libs/jszip/3.5.0/jszip.min.js"></script>
		<script src="https://cdn.bootcdn.net/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
		<?php } ?>
		<script>
		if ((location.href || '').indexOf('vconsole=true') > -1) {
			document.write('<script src="https://cdn.bootcss.com/vConsole/3.3.0/vconsole.min.js"><\/script>');
			document.write('<script>new VConsole()<\/script>');
		}
		</script>
		<?php
		$h = date("H");if( ( $h>=19 && $h<=24 ) || ( $h>=0 && $h<7 ) ){?>
		<style>
			html, body {
				background-color: #181a1b;
			}
			#ghost_box_1 article, #ghost_box_2 article, .setting article, .postrank article, .zone_list_box article, .more-post, .home_title_menu_item,#ghost_slide .ghost_control,.ghost_site_notice,body>.footer .footer-wrap>.footer-nav,.ghost_bottom_tools,.ghost_user_menu_nav,.poi-crumb,.ghost_hot_post_post,.ghost_author_widget,.article article,.single_post_body p,.ghost_user_menu_item_link,.ghost_search_form,.ghost_search_form_s,.zone-type-menu li button, .po-zone-tools-right button,.ghost_sign_nav,.ghost_author_nav,.ghost_author_portal,.ghost_author_comment_container,.ghost_author_comment_item_text,.ghost_setting_content_item,.ghost_sidebar,.ghost_guajian_shop_title_menu_item,.ghost_setting_content_preface_control,.ghost_setting_content_text_email,.ghost_setting_content_preface_control_downloadlink, .ghost_setting_content_preface_control_videolink, .ghost_setting_content_preface_control_musiclink,.tox .tox-edit-area__iframe,.tox .tox-toolbar, .tox .tox-toolbar__overflow, .tox .tox-toolbar__primary,.tox .tox-menubar,.ghost_page_box,.ghost_login_box_container, .ghost_comments_box_container, .ghost_reports_box_container, .ghost_addlink_box_container, .ghost_shops_box_container, .ghost_yanwen_container, .ghost_tuwen_container, .ghost_sign_container,.tox .tox-tbtn,.tox .tox-mbtn,.tox .tox-tbtn svg,.tox .tox-statusbar,.header-menu nav>.header-menu-div>ul>li>.sub-menu,.ghost_input,.ghost_comment_container,.ghost_comment_commenter_content,.ghost_comment_item_content_text,.error_page,.layer,.ghost_report_item, .ghost_addlink_item,.ghost_report_reporter_content, .ghost_addlink_reporter_content,.ghost_login_box_content_input,.single_post_body li {
				background-color: #232627!important;
				color: #B1B1C1!important;
			}
			img {
				-webkit-filter: brightness(50%); /*考虑浏览器兼容性：兼容 Chrome, Safari, Opera */
				filter: brightness(50%);
			}
			.header-tu,.ghost-header-logo {
				-webkit-filter: brightness(50%);
				filter: brightness(50%);
			}
		</style>
		<?php }?>
	</head>
<body>
<?php if(!wp_is_mobile()): ?>
<div style="background-image:url(<?php echo ghost_get_option('ghost_site_head_pic') ?>);" class="header-tu">
    <div class="container"> 
        <div class="header-yonghu poi-container"> 
            <nav class="ghost-topbar">
                <ul class="menu">
					<?php foreach(ghost_get_option('ghost_head_menu') as $value){?>
                    <li class="ghost-topbar-item is-icon-text"><a href="<?php echo $value['ghost_head_menu_link'] ?>" title="<?php echo $value['ghost_head_menu_name'] ?>" target="_self"><i style="font-size: 1.2em;" class="fas <?php echo $value['ghost_head_menu_fa'] ?> fa-2x poi-icon" aria-hidden="true"></i> <span> <?php echo $value['ghost_head_menu_name'] ?></span></a></li>		
					<?php } ?>
                </ul>
            </nav> 
        </div>
        <!-- Logo -->
        <div class="ghost-head-nav">
            <a class="logo nav-col" href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>">
                <img class="ghost-logo" src="<?php echo ghost_get_option('ghost_site_logo') ?>" alt="<?php bloginfo('name'); ?>">
            </a>
        </div>
    </div>
</div>
<div class="scroll-header-menu container"><!-- 菜单 -->
    <header id="scroll-header" class="header-menu">
        <div style="margin:0px auto" class="header white">
            <div class="ghost-header-logo"> 
            <div style="background-image:url(<?php echo ghost_get_option('ghost_site_head_pic') ?>);" class="header-bg">
            </div>
            </div>
            <nav id="header-nav" class="navigation clearfix" role="navigation">
            
            <?php 
						echo $menu;
            ?> 
        <div class="ghost-nav-tool__container">
            <?php if(is_user_logged_in()){
                $deflink = empty(ghost_get_option('ghost_site_me_link')) ? 'me' : ghost_get_option('ghost_site_me_link');
                $sign_daily = (get_user_meta($user_id, 'sign_daily', true) > 0) ? get_user_meta($user_id, 'sign_daily', true) : 0;
                $getTime  = getTime();
                if(!($getTime['star'] < $sign_daily && $getTime['end'] > $sign_daily) || !$sign_daily):
                ?>
                <div class="ghost_sign_daily">
                    <a class="ghost_sign_daily_btn" title="签到">
                    <span class="poi-icon fa-map-marker fas fa-fw" aria-hidden="true"></span> 
                    <span class="poi-icon__text">签到</span>
                    </a>
                </div>
                <?php else: ?>
                <div class="ghost_sign_daily">
                    <a class="ghost_sign_daily_btn" title="已签到">
                    <span class="poi-icon fa-map-marker fas fa-fw" aria-hidden="true"></span> 
                    <span class="poi-icon__text">已签到</span>
                    </a>
                </div>
                <?php endif; ?>
                <li class="login-actions">
							<?php if(get_unread_num($user_id) || get_add_user_notice_read($user_id)){echo '<i class="ghost-author-posts-count" title="未读消息数量" style="background: red;border-radius: 50%;right: 48px;top: 5px;padding: 5px;"></i>';}?>
                    <a style="padding:0px;background: hsla(0, 0%, 100%, 0);" class="login-link bind-redirect">
						<?php if(get_user_meta($current_user->ID,'ghost_guajian',true)){ ?>
								<img src="<?php echo get_user_meta($current_user->ID,'ghost_guajian',true) ?>" alt="" class="ghost_guajian">
						<?php } ?>
								<img src="<?php echo get_user_meta($current_user->ID,'ghost_user_avatar',true) ?>" alt="avatar" class="ghost_setting_content_avatar_img" width="100" height="100">
								</a>

                    <div class="ghost_user_menu_nav">
                        <div class="ghost_user_menu_item">
                            <div class="ghost_user_menu_item_title">
                                <div class="ghost_user_menu_item_title_icon">
                                    <i class="poi-icon fas fa-address-card" aria-hidden="true"></i>
                                </div>
                                <div class="ghost_user_menu_item_title_text">个人设置</div></div>
                            <a href="<?php echo home_url('/'.$deflink.'/setting'); ?>" title="我的设置" class="ghost_user_menu_item_link">
                                <div class="ghost_user_menu_item_link_icon">
                                    <i class="poi-icon fas fa-cog" aria-hidden="true"></i>
                                </div>
                                <div class="ghost_user_menu_item_link_text">我的设置</div></a>
                            <a href="<?php echo home_url('/'.$deflink.'/drafts'); ?>" title="我的草稿" class="ghost_user_menu_item_link">
                                <div class="ghost_user_menu_item_link_icon">
                                    <i class="poi-icon fas fa-copy" aria-hidden="true"></i>
                                </div>
                                <div class="ghost_user_menu_item_link_text">我的草稿</div></a>
                            <a href="<?php echo home_url('/'.$deflink.'/newpost'); ?>" title="新建文章" class="ghost_user_menu_item_link">
                                <div class="ghost_user_menu_item_link_icon">
                                    <i class="poi-icon fas fa-paint-brush" aria-hidden="true"></i>
                                </div>
                                <div class="ghost_user_menu_item_link_text">新建文章</div></a>
                        </div>
                        <div class="ghost_user_menu_item">
                            <div class="ghost_user_menu_item_title">
                                <div class="ghost_user_menu_item_title_icon">
                                    <i class="poi-icon fa-bell fas" aria-hidden="true"></i>
                                </div>
                                <div class="ghost_user_menu_item_title_text">消息管理</div></div>
										<?php if(get_add_user_notice_read($user_id)){echo '<i style="top: 64px;right: 82px;" class="ghost-author-posts-count" title="未读通知数量">'.get_add_user_notice_read($user_id).'</i>';}?>
                            <a href="<?php echo home_url('/'.$deflink.'/notice'); ?>" title="我的通知" class="ghost_user_menu_item_link">
                                <div class="ghost_user_menu_item_link_icon">
                                    <i class="poi-icon fas fa-bell" aria-hidden="true"></i>
                                </div>
                                <div class="ghost_user_menu_item_link_text">我的通知</div></a>
										<?php if(get_unread_num($user_id)){echo '<i class="ghost-author-posts-count" title="未读消息数量">'.get_unread_num($user_id).'</i>';}?>
                            <a href="<?php echo home_url('/'.$deflink.'/msg'); ?>" title="我的消息" class="ghost_user_menu_item_link">
                                <div class="ghost_user_menu_item_link_icon">
                                    <i class="poi-icon fas fa-envelope" aria-hidden="true"></i>
                                </div>
                                <div class="ghost_user_menu_item_link_text">我的消息</div></a>
                            <a href="<?php echo home_url('/'.$deflink.'/orders'); ?>" title="我的订单" class="ghost_user_menu_item_link">
                                <div class="ghost_user_menu_item_link_icon">
                                    <i class="poi-icon fas fa-shopping-cart" aria-hidden="true"></i>
                                </div>
                                <div class="ghost_user_menu_item_link_text">我的订单</div></a>
                        </div>
                        <div class="ghost_user_menu_item">
                            <div class="ghost_user_menu_item_title">
                                <div class="ghost_user_menu_item_title_icon">
                                    <i class="poi-icon fas fa-user-circle" aria-hidden="true"></i>
                                </div>
                                <div class="ghost_user_menu_item_title_text">个人中心</div></div>
                            <a href="<?php echo ghost_get_user_author_link($user_id).'?type=stars'; ?>" title="我的收藏" class="ghost_user_menu_item_link">
                                <div class="ghost_user_menu_item_link_icon">
                                    <i class="poi-icon fas fa-heart" aria-hidden="true"></i>
                                </div>
                                <div class="ghost_user_menu_item_link_text">我的收藏</div></a>
                            <a href="<?php echo ghost_get_user_author_link($user_id).'?type=posts'; ?>" title="我的文章" class="ghost_user_menu_item_link">
                                <div class="ghost_user_menu_item_link_icon">
                                    <i class="poi-icon fas fa-file-alt" aria-hidden="true"></i>
                                </div>
                                <div class="ghost_user_menu_item_link_text">我的文章</div></a>
                            <a href="<?php echo ghost_get_user_author_link($user_id).'?type=fans'; ?>" title="我的粉丝" class="ghost_user_menu_item_link">
                                <div class="ghost_user_menu_item_link_icon">
                                    <i class="poi-icon fa-users fas" aria-hidden="true"></i>
                                </div>
                                <div class="ghost_user_menu_item_link_text">我的粉丝</div></a>
                        </div>
                        <div class="ghost_user_menu_item">
                            <div class="ghost_user_menu_item_title">
                                <div class="ghost_user_menu_item_title_icon">
                                    <i class="poi-icon fas fa-user-circle" aria-hidden="true"></i>
                                </div>
                                <div class="ghost_user_menu_item_title_text">我的会员</div></div>
                            <a href="<?php echo home_url('/'.$deflink.'/vip'); ?>" title="我的会员" class="ghost_user_menu_item_link">
                                <div class="ghost_user_menu_item_link_icon">
                                    <i class="poi-icon fas fa-user-circle" aria-hidden="true"></i>
                                </div>
                                <div class="ghost_user_menu_item_link_text">我的会员</div></a>
                            <a href="<?php echo home_url('/'.$deflink.'/cash'); ?>" title="我的余额" class="ghost_user_menu_item_link">
                                <div class="ghost_user_menu_item_link_icon">
                                    <i class="poi-icon fas fa-credit-card" aria-hidden="true"></i>
                                </div>
                                <div class="ghost_user_menu_item_link_text">我的余额</div></a>
                            <a href="<?php echo home_url('/'.$deflink.'/credits'); ?>" title="我的积分" class="ghost_user_menu_item_link">
                                <div class="ghost_user_menu_item_link_icon">
                                    <i class="poi-icon fas fa-gem" aria-hidden="true"></i>
                                </div>
                                <div class="ghost_user_menu_item_link_text">我的积分</div></a>
                        </div>
                        <div class="ghost_user_menu_item">
                            <div class="ghost_user_menu_item_title">
                                <div class="ghost_user_menu_item_title_icon">
                                    <i class="poi-icon fas fa-unlock" aria-hidden="true"></i>
                                </div>
                                <div class="ghost_user_menu_item_title_text">管理设置</div></div>
										  <a href="<?php echo home_url('/'.$deflink.'/shop'); ?>" title="商城中心" class="ghost_user_menu_item_link">
                                <div class="ghost_user_menu_item_link_icon">
                                    <i class="poi-icon fas fa-gem" aria-hidden="true"></i>
                                </div>
                                <div class="ghost_user_menu_item_link_text">商城中心</div></a>
                            <a href="<?php echo home_url('/'.$deflink.'/price'); ?>" title="积分抽奖" class="ghost_user_menu_item_link">
                                <div class="ghost_user_menu_item_link_icon">
                                    <i class="poi-icon fas fa-gem" aria-hidden="true"></i>
                                </div>
                                <div class="ghost_user_menu_item_link_text">积分抽奖</div></a>
                            <?php if(current_user_can('level_10')){ ?>
                            <a href="<?php echo home_url('/wp-admin'); ?>" title="后台管理" class="ghost_user_menu_item_link">
                                <div class="ghost_user_menu_item_link_icon">
                                    <i class="poi-icon fas fa-gem" aria-hidden="true"></i>
                                </div>
                                <div class="ghost_user_menu_item_link_text">后台管理</div></a>
                            <?php } ?>
                            <a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="注销账号" class="ghost_user_menu_item_link">
                                <div class="ghost_user_menu_item_link_icon">
                                    <i class="poi-icon fas fa-sign-out-alt" aria-hidden="true"></i>
                                </div>
                                <div class="ghost_user_menu_item_link_text">注销账号</div></a>
                        </div>
                    </div>

                </li>
            <?php }else{ ?>
                <li class="login-actions">
                    <a class="user-login login-link bind-redirect"><span>登陆</span></a>
                </li>
            <?php } ?>
            <div class="ghost_header_search_anniu ghost-search-bar_toggle-btn_container"><a class="poi-icon fa-search fa fa-2x ghost-search-bar_btn" aria-label="搜索" title="搜索"></a></div>
            </div>
            </nav>
        </div>
    </header>
</div>
<?php else: ?>
<div class="mobile"><!-- 菜单 -->
    <header id="scroll-header" class="header-menu">
        <div style="margin:0px auto" class="header white">
            <div class="ghost-header-logo"> 
            <div style="background-image:url(<?php echo ghost_get_option('ghost_site_head_pic') ?>);" class="header-bg">
            </div>
            </div>
            <nav id="header-nav" class="navigation clearfix" role="navigation">
                <div class="ghost_menu_open"><i class="ghost_menu_open_btn fas fa-bars"></i></div>
                <a href="<?php bloginfo('url'); ?>" class="ghost_menu_img_link" rel="home">
                    <img width="200" height="88" src="<?php echo ghost_get_option('ghost_site_logo') ?>" class="ghost_menu_img" alt="<?php bloginfo('name'); ?>">
                </a>
                <div class="ghost_mobilemenu_container">
                    <a href="<?php bloginfo('url'); ?>" class="ghost_mobilemenu_container_title"><?php bloginfo('name'); ?></a>
                <?php 
                    wp_nav_menu( array( 'theme_location'=>'menu-pc', 'depth' => 2, 'container_class' => 'header-menu-mobile') );
                ?>
                </div>
                <div class="ghost-nav-tool__container">
                    <?php if(is_user_logged_in()){
                        $deflink = empty(ghost_get_option('ghost_site_me_link')) ? 'me' : ghost_get_option('ghost_site_me_link');
                        $sign_daily = (get_user_meta($user_id, 'sign_daily', true) > 0) ? get_user_meta($user_id, 'sign_daily', true) : 0;
                        $getTime  = getTime();
                        if(!($getTime['star'] < $sign_daily && $getTime['end'] > $sign_daily) || !$sign_daily):
                    ?>
                    <div class="ghost_sign_daily">
                        <a class="ghost_sign_daily_btn" title="签到">
                        <span class="poi-icon fa-map-marker fas fa-fw" aria-hidden="true"></span> 
                        <span class="poi-icon__text">签到</span>
                        </a>
                    </div>
                    <?php else: ?>
                    <div class="ghost_sign_daily">
                        <a class="ghost_sign_daily_btn" title="已签到">
                        <span class="poi-icon fa-map-marker fas fa-fw" aria-hidden="true"></span> 
                        <span class="poi-icon__text">已签到</span>
                        </a>
                    </div>
                    <?php endif; ?>
                        <li class="ghost_mobile_author_menu user-actions">
                            <a style="padding:0px;background: hsla(0, 0%, 100%, 0);" class="login-link bind-redirect"><img src="<?php echo get_user_meta($current_user->ID,'ghost_user_avatar',true) ?>" alt="avatar" class="ghost_setting_content_avatar_img" width="100" height="100"></a>

                            <div class="ghost_mobileusermenu_container">
                                <div class="ghost_mobileusermenu_header">
                                    <div class="ghost_mobileusermenu_header_mask" style="background-image: url(<?php echo get_user_meta($current_user->ID,'ghost_user_avatar',true) ?>);"></div>
                                    <a class="ghost_mobileusermenu_header_avatar" href="<?php echo ghost_get_user_author_link($user_id); ?>">
                                        <img class="ghost_mobileusermenu_header_avatar_img" src="<?php echo get_user_meta($current_user->ID,'ghost_user_avatar',true) ?>" width="50" height="50" alt="">
                                        <span class="ghost_mobileusermenu_header_avatar_name"><?php echo get_user_meta($current_user->ID,'nickname',true) ?></span></a>
                                    <div class="ghost_mobileusermenu_header_point">
                                        <span class="poi-icon <?php echo ghost_get_option('ghost_user_gem') ?> fa-fw" aria-hidden="true"></span>
                                        <span class="poi-icon__text"><?php echo get_user_meta($current_user->ID,'user_credit',true) ?></span></div>
                                </div>
                                <div class="header-menu-mobile">
                                    <ul id="menu-catacg" class="menu">
                                        <li>
                                            <a>
                                                <i class="catacg-mune-tubiao fas fa-address-card"></i>个人设置</a>
                                            <ul class="sub-menu">
                                                <li>
                                                    <a href="<?php echo home_url('/'.$deflink.'/setting'); ?>">
                                                    <i class="catacg-mune-tubiao fas fa-cog"></i>我的设置</a></li>
                                                    <li>
                                                    <a href="<?php echo home_url('/'.$deflink.'/drafts'); ?>">
                                                    <i class="catacg-mune-tubiao fas fa-copy"></i>我的草稿</a></li>
                                                    <li>
                                                    <a href="<?php echo home_url('/'.$deflink.'/newpost'); ?>">
                                                    <i class="catacg-mune-tubiao fas fa-paint-brush"></i>新建文章</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a>
                                                <i class="catacg-mune-tubiao fas fa-bell"></i>消息管理</a>
                                            <ul class="sub-menu">
                                                <li>
                                                    <a href="<?php echo home_url('/'.$deflink.'/notice'); ?>">
                                                    <i class="catacg-mune-tubiao fas fa-bell"></i>我的通知</a></li>
                                                    <li>
                                                    <a href="<?php echo home_url('/'.$deflink.'/msg'); ?>">
                                                    <i class="catacg-mune-tubiao fas fa-envelope"></i>我的消息</a></li>
                                                    <li>
                                                    <a href="<?php echo home_url('/'.$deflink.'/orders'); ?>">
                                                    <i class="catacg-mune-tubiao fas fa-shopping-cart"></i>我的订单</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a>
                                                <i class="catacg-mune-tubiao fas fa-address-card"></i>个人中心</a>
                                            <ul class="sub-menu">
                                                <li>
                                                    <a href="<?php echo ghost_get_user_author_link($user_id); ?>">
                                                    <i class="catacg-mune-tubiao fas fa-heart"></i>我的收藏</a></li>
                                                    <li>
                                                    <a href="<?php echo ghost_get_user_author_link($user_id); ?>">
                                                    <i class="catacg-mune-tubiao fas fa-file-alt"></i>我的文章</a></li>
                                                    <li>
                                                    <a href="<?php echo ghost_get_user_author_link($user_id); ?>">
                                                    <i class="catacg-mune-tubiao fas fa-users"></i>我的粉丝</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a>
                                                <i class="catacg-mune-tubiao fas fa-address-card"></i>我的会员</a>
                                            <ul class="sub-menu">
                                                <li>
                                                    <a href="<?php echo home_url('/'.$deflink.'/vip'); ?>">
                                                    <i class="catacg-mune-tubiao fas fa-user-circle"></i>我的会员</a></li>
                                                    <li>
                                                    <a href="<?php echo home_url('/'.$deflink.'/cash'); ?>">
                                                    <i class="catacg-mune-tubiao fas fa-credit-card"></i>我的余额</a></li>
                                                    <li>
                                                    <a href="<?php echo home_url('/'.$deflink.'/credits'); ?>">
                                                    <i class="catacg-mune-tubiao fas fa-gem"></i>我的积分</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a>
                                                <i class="catacg-mune-tubiao fas fa-address-card"></i>管理设置</a>
                                            <ul class="sub-menu">
                                                <li>
                                                    <a href="<?php echo home_url('/'.$deflink.'/price'); ?>">
                                                    <i class="catacg-mune-tubiao fas fa-cog"></i>积分抽奖</a></li>
                                                    <li>
                                                    <?php if(current_user_can('level_10')){ ?>
                                                    <a href="<?php echo home_url('/wp-admin'); ?>">
                                                    <i class="catacg-mune-tubiao fas fa-cog"></i>后台管理</a></li>
                                                    <li>
                                                    <?php } ?>
                                                    <a href="<?php echo wp_logout_url( get_permalink() ); ?>">
                                                    <i class="catacg-mune-tubiao fas fa-sign-out-alt"></i>注销账号</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </li>
                    <?php }else{ ?>
                        <li class="login-actions">
                            <a class="user-login login-link bind-redirect"><span>登陆</span></a>
                        </li>
                    <?php } ?>
                    <div class="ghost_header_search_anniu ghost-search-bar_toggle-btn_container"><a class="poi-icon fa-search fa fa-2x ghost-search-bar_btn" aria-label="搜索" title="搜索"></a></div>
            </div>
        </nav>
                </div>
    </header>
</div>
<?php endif; ?>