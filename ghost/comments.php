<?php 
global $current_user,$wpdb;
$user_id = $current_user->ID; ?>
<div class="ghost_comment">
    <?php if(!is_user_logged_in()){?>
        <div class="<?php echo get_my_login_type(); ?> ghost_comment_faker">
                <img class="ghost_comment_faker_avatar" src="https://sinaimg.inn-studio.com/large/686ee05djw1f5dm9khva8j2074074dfn.jpg" alt="avatar" width="18" height="18">
                <span class="ghost_comment_text">登录后才能评论哦！</span></div>
    <?php }else{ ?>
        <div class="join_comments ghost_comment_faker">
                <img class="ghost_comment_faker_avatar" src="<?php echo get_user_meta($user_id,'ghost_user_avatar',true) ?>" alt="avatar" width="18" height="18">
                <span class="ghost_comment_text">点击参与讨论！</span></div>
    <?php } ?>
        <h2 class="ghost_comment_title">
                <span class="poi-icon fa-comments fas fa-fw" aria-hidden="true"></span>
                <span class="ghost_icon_text">评论</span></h2>
        <div class="ghost_comment_container">
            <div>
            <?php
					wp_list_comments(array(
						'style' => 'div',
						'short_ping' => true,
						'end-callback' => 'ghost_comment_callback_close',
						'callback' => 'simple_comment',
						'max_depth'=>2
					));
            ?>
            </div>
        </div>
</div>
