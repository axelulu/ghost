<?php 
 class ghost_author extends WP_Widget {
  
     function __construct()
     {
         $widget_ops = array('description' => '作者小工具');
         parent::__construct(false,$name='作者小工具',$widget_ops);  
     }
  
     function form($instance) { // 给小工具(widget) 添加表单内容
        $title = esc_attr($instance['title']);
     ?>
     <p><label for="<?php echo $this->get_field_id('title'); ?>">
            标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </label>
    </p>
     <?php
     }
     function update($new_instance, $old_instance) { // 更新保存
         return $new_instance;
     }
     function widget($args, $instance) { // 输出显示在页面上
     extract( $args );
         $title = apply_filters('widget_title', empty($instance['title']) ? __('作者工具') : $instance['title']);
         ?>
            <?php echo $before_widget;
            $user_id = get_post(get_the_ID())->post_author; ?>
            <h3 class="ghost_hot_post_title">
                <span>
                    <i class="fas fa-user-circle"></i>
                    <span><?php echo $title ?></span></span>
            </h3>
            <div data-uid="<?php echo $user_id; ?>" class="ghost_author_header ghost_my_flowers ghost_author_widget">
                <div class="ghost_author_widget_container">
                    <div class="ghost_author_widget_avatar">
                        <a class="ghost_author_widget_avatar_link" href="<?php echo ghost_get_user_author_link($user_id); ?>">
                            <img class="ghost_author_widget_avatar_img" width="150" height="150" src="<?php echo get_user_meta($user_id,'ghost_user_avatar',true) ?>" alt="<?php echo get_user_meta($user_id,'nickname',true) ?>"></a>
                    </div>
                    <div class="ghost_author_widget_info">
                        <div class="ghost_author_widget_name_container">
                            <a href="<?php echo ghost_get_user_author_link($user_id); ?>" class="ghost_author_widget_name_link"><?php echo get_user_meta($user_id,'nickname',true) ?></a></div>
                        <div class="ghost_author_widget_group_container">
                            <div class="ghost_author_widget_group_uid" title="UID"><?php echo get_user_meta($user_id,'ID',true) ?></div>
                            <div class="ghost_author_widget_group_role" style="background-color: rgb(165, 132, 168);"><?php echo ghost_user_type($user_id); ?></div></div>
                        <div class="ghost_author_widget_description"><?php echo get_user_meta($user_id,'description',true) ?></div></div>
                    <div class="ghost_author_widget_point">
                    <span class="poi-icon <?php echo ghost_get_option('ghost_user_gem') ?> fa-fw" aria-hidden="true"></span>
                        <span class="ghost_author_widget_point_text"><?php echo get_user_meta($user_id,'user_credit',true) ?></span></div>
                    <div class="ghost_author_widget_tools">
                        <a class="ghost-btn ghost-btn_success ghost_author_btn <?php echo get_my_login_type('my_flower'); ?>">
                            <?php
                            global $current_user,$wpdb;
                            $fans = $current_user->ID;
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
                    <div class="ghost_author_widget_author_profile_count">
                        <a class="ghost_author_widget_count_item" href="<?php echo ghost_get_user_author_link($user_id).'?type=flowers'; ?>">
                            <div class="ghost_author_widget_item_number"><?php echo ghost_get_flower_num($user_id) ?></div>
                            <div class="ghost_author_widget_item_name">关注</div></a>
                        <a class="ghost_author_widget_count_item" href="<?php echo ghost_get_user_author_link($user_id).'?type=fans'; ?>">
                            <div class="ghost_author_widget_item_number"><?php echo ghost_get_fans_num($user_id) ?></div>
                            <div class="ghost_author_widget_item_name">粉丝</div></a>
                        <a class="ghost_author_widget_count_item" href="<?php echo ghost_get_user_author_link($user_id).'?type=posts'; ?>">
                            <div class="ghost_author_widget_item_number"><?php echo count_user_posts($user_id, 'post', false); ?></div>
                            <div class="ghost_author_widget_item_name">帖子</div></a>
                        <a class="ghost_author_widget_count_item" href="<?php echo ghost_get_user_author_link($user_id).'?type=comments'; ?>">
                            <div class="ghost_author_widget_item_number"><?php echo get_comments('count=true&user_id='.$user_id); ?></div>
                            <div class="ghost_author_widget_item_name">评论</div></a>
                    </div>
                </div>
            </div>
            <?php echo $after_widget; ?>
  
         <?php
     }
 }
 register_widget('ghost_author');
 ?>