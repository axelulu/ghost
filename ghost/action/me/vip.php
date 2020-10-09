<?php
require( '../../../../../wp-load.php' );
global $current_user;
$user_id = $current_user->ID;
$user_data = get_userdata($user_id);
if( current_user_can( 'visitor' ) ) {
    $user_type = '游客';
    $dati_type = '您还未参与答题';
}elseif( current_user_can( 'vip' )){
    $user_type = '正式会员';
    $dati_type = '您已经通过了答题测试！';
}elseif( current_user_can( 'svip' )){
    $user_type = '大会员';
    $dati_type = '您已经是大会员了，无需答题！';
}elseif( current_user_can( 'administrator' )){
    $user_type = '超级管理员';
    $dati_type = '您已经是超级管理员了，无需答题！';
}
$user_credit = get_user_meta($user_id,'user_credit',true);
?>
<div class="ghost_setting_content">
    <div class="drafts ghost_setting_content_container">
        <fieldset class="ghost_setting_content_item">
            <legend class="ghost_setting_content_item_title">
                <span class="ghost_setting_content_primary">
                    <span class="poi-icon fa-user-circle fas fa-fw" aria-hidden="true"></span>
                    <span class="ghost_setting_content_text">会员信息</span></span>
            </legend>
            <div class="ghost_setting_content_item_content">
                <div class="ghost_setting_content_preface">
                    <p>您可以在这个页面查看您发布过的帖子，鼠标悬浮即可见编辑按钮。</p>
                    <p>重新编辑帖子后需要二次审核，请谨慎编辑哦！</p>
                </div>
                <div class="ghost_notice_content_preface">
                    <div class="ghost_author_portal_portal_item">
                        <div class="ghost_author_portal_item_title">昵称</div>
                        <div class="ghost_author_portal_item_content"><?php echo $user_data->nickname ?></div></div>
                    <div class="ghost_author_portal_portal_item">
                        <div class="ghost_author_portal_item_title">UID</div>
                        <div class="ghost_author_portal_item_content"><?php echo $user_id ?></div></div>
                    <div class="ghost_author_portal_portal_item">
                        <div class="ghost_author_portal_item_title">描述</div>
                        <div class="ghost_author_portal_item_content"><?php echo $user_data->description ?></div>
                    </div>
                    <div class="ghost_author_portal_portal_item">
                        <div class="ghost_author_portal_item_title">身份状态：</div>
                        <div class="ghost_author_portal_item_content"><?php echo $user_type ?></div>
                    </div>
                    <div class="ghost_author_portal_portal_item">
                        <div class="ghost_author_portal_item_title">答题状态：</div>
                        <div class="ghost_author_portal_item_content"><?php echo $dati_type ?></div>
                    </div>
                    <div class="ghost_author_portal_portal_item">
                        <div class="ghost_author_portal_item_title">积分信息：</div>
                        <div class="ghost_author_portal_item_content"><?php echo $user_credit ?></div>
                    </div>
                    <div class="ghost_author_portal_portal_item">
                        <div class="ghost_author_portal_item_title">累计发帖</div>
                        <div class="ghost_author_portal_item_content"><?php echo wp_count_posts()->publish; ?></div></div>
                    <div class="ghost_author_portal_portal_item">
                        <div class="ghost_author_portal_item_title">累计评论</div>
                        <div class="ghost_author_portal_item_content"><?php echo get_comments('count=true&user_id='.$user_data->ID); ?></div>
                    </div>
                    <?php 
                    ?>
                </div>
            </div>
        </fieldset>
    </div>
</div>