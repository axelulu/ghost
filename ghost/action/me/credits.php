<?php
require( '../../../../../wp-load.php' );?>
<div class="ghost_setting_content">
    <div class="drafts ghost_setting_content_container">
        <fieldset class="ghost_setting_content_item">
            <legend class="ghost_setting_content_item_title">
                <span class="ghost_setting_content_primary">
                    <span class="poi-icon fa-user-circle fas fa-fw" aria-hidden="true"></span>
                    <span class="ghost_setting_content_text">投稿须知</span></span>
            </legend>
            <div class="ghost_setting_content_item_content">
                <div class="ghost_setting_content_preface">
                    <p>您可以在这个页面查看您发布过的帖子，鼠标悬浮即可见编辑按钮。</p>
                    <p>重新编辑帖子后需要二次审核，请谨慎编辑哦！</p>
                </div>
                <div class="ghost_notice_content_preface">
                    <?php if( current_user_can( 'visitor' ) ) {
                        echo '游客';
                    }elseif( current_user_can( 'vip' )){
                        echo '正式会员';
                    }elseif( current_user_can( 'svip' )){
                        echo '大会员';
                    }elseif( current_user_can( 'administrator' )){
                        echo '超级管理员';
                    }
                    ?>
                </div>
            </div>
        </fieldset>
    </div>
</div>