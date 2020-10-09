<?php
get_header();
global $current_user,$wpdb;
$fans = $current_user->ID;
$user_id =  get_query_var('author');
$user_data = get_userdata($user_id);
?>
<div class="main author">
    <div class="container">
        <div data-uid="<?php echo $user_id; ?>" class="ghost_author_header">
            <div class="ghost_my_flowers ghost_author_container">
                <div class="ghost_author_avatar_container">
                    <div class="ghost_author_avatar">
                    <img alt="" src="<?php echo get_user_meta($user_id,'ghost_user_avatar',true) ?>" class="avatar avatar-96 photo" height="96" width="96"></div>
                    <div class="ghost_author_name"><?php echo $user_data->nickname ?></div>
                    <div class="ghost_author_level">
                        <span class="ghost_author_poi-label" style="background-color: #e1b32a"><?php echo ghost_user_type($user_id); ?></span></div>
                </div>
                <div id="ghost_author_tools_container" class="ghost_author_tools_container">
                    <div class="poi-btn-group">
                        <a class="ghost-btn ghost-btn_success ghost_author_btn <?php echo get_my_login_type('my_flower'); ?>">
                            <?php
                            $request = "SELECT fans_id FROM wp_ghost_fans WHERE fans_id=$fans";
                            $fan = $wpdb->query($request);
                            if($fan){?>
                                <div class="del_flowers">
                                <span class="poi-icon fa-check fas fa-fw" aria-hidden="true"></span>
                                <span class="ghost_icon_text">已关注</span>
                                </div>
                            <?php }else{ ?>
                                <div class="flowers">
                                <span class="poi-icon fa-plus fas fa-fw" aria-hidden="true"></span>
                                <span class="ghost_icon_text">加关注</span>
                                </div>
                            <?php } ?>
                        </a>
                        <a class="ghost-btn ghost-btn_default ghost_author_btn <?php echo get_my_login_type('send_msg'); ?>">
                            <span class="poi-icon fa-envelope fas fa-fw" aria-hidden="true"></span>
                            <span class="ghost_icon_text">站内信</span></a>
                    </div>
                </div>
            </div>
        </div>
        <nav>
            <ul class="ghost_author_nav">
                <li class="ghost_author_nav_item <?php if(isset($_GET["type"])){echo get_author_type($_GET["type"],'msg');}else{echo 'is-active';} ?>">
                    <a data-slug="msg" title="总览" class="ghost_author_nav_item_item_link msg">
                        <i class="fa-newspaper fas fa-fw poi-icon" aria-hidden="true"></i>
                        <span class="ghost_icon_text">总览</span></a>
                </li>
                <li class="ghost_author_nav_item <?php echo get_author_type($_GET["type"],'stars');?>">
                    <a data-slug="stars" title="帖子" class="ghost_author_nav_item_item_link posts">
                        <i class="fa-link fas fa-fw poi-icon" aria-hidden="true"></i>
                        <span class="ghost_icon_text">收藏帖子</span></a>
                </li>
                <li class="ghost_author_nav_item <?php echo get_author_type($_GET["type"],'posts');?>">
                    <a data-slug="posts" title="帖子" class="ghost_author_nav_item_item_link posts">
                        <i class="fa-paint-brush fas fa-fw poi-icon" aria-hidden="true"></i>
                        <span class="ghost_icon_text">我的帖子</span></a>
                </li>
                <li class="ghost_author_nav_item <?php echo get_author_type($_GET["type"],'flowers');?>">
                    <a data-slug="flowers" title="关注" class="ghost_author_nav_item_item_link flowers">
                        <i class="fa-user-plus fas fa-fw poi-icon" aria-hidden="true"></i>
                        <span class="ghost_icon_text">关注</span></a>
                </li>
                <li class="ghost_author_nav_item <?php echo get_author_type($_GET["type"],'fans');?>">
                    <a data-slug="fans" title="粉丝" class="ghost_author_nav_item_item_link fans">
                        <i class="fa-users fas fa-fw poi-icon" aria-hidden="true"></i>
                        <span class="ghost_icon_text">粉丝</span></a>
                </li>
                <li class="ghost_author_nav_item <?php echo get_author_type($_GET["type"],'comments');?>">
                    <a data-slug="comments" title="评论" class="ghost_author_nav_item_item_link comments">
                        <i class="fa-comments fas fa-fw poi-icon" aria-hidden="true"></i>
                        <span class="ghost_icon_text">评论</span></a>
                </li>
            </ul>
        </nav>
        <div id="ajax-author">
				<script>jQuery(function ($) {$('.is-active .ghost_author_nav_item_item_link').trigger('click');});</script>
        </div>
    </div>
</div>
<?php get_footer();?>