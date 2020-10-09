<?php
require( '../../../../../wp-load.php' );
global $current_user;
$user_id = $current_user->ID;?>
<div class="ghost_setting_content">
    <div class="drafts ghost_setting_content_container">
        <fieldset class="ghost_setting_content_item">
            <legend class="ghost_setting_content_item_title">
                <span class="ghost_setting_content_primary">
                    <span class="poi-icon fa-user-circle fas fa-fw" aria-hidden="true"></span>
                    <span class="ghost_setting_content_text">系统通知</span></span>
            </legend>
            <div class="ghost_setting_content_item_content">
                <div class="ghost_msg_container">
                    <div class="ghost_msg_nav">
                        <form class="ghost_msg_item_fm" action="javascript:;">
                            <input type="text" class="ghost_setting_content_preface_control_downloadlink msg_input" placeholder="输入用户 UID 以对话" title="输入用户 UID 以对话" required="" value="">
                            <input type="submit" hidden=""></form>
                        <div class="user_msg">
                            <?php 
                                global $wpdb;
                                $request = "SELECT from_id,user_id,type,content_type,msg_time,status FROM wp_ghost_message WHERE user_id=$user_id";
                                $user_lists = $wpdb->get_results($request);
                                if($user_lists){
                                    foreach ( $user_lists as $user_list ) {
                                        if($user_list->type=='add_user_list'){
                                            echo    '<div class="ghost_msg_nav_item '.is_active($user_id,$user_list->from_id).'">
                                                        <a class="ghost_msg_nav_item_author_link change_user_content" data-id="'.$user_list->from_id.'" title="'.get_user_meta($user_list->from_id,'nickname',true).'">
                                                            <img class="ghost_msg_nav_item_author_avatar_img" src="'.get_user_meta($user_list->from_id,'ghost_user_avatar',true).'" alt="'.get_user_meta($user_list->from_id,'nickname',true).'" width="24" height="24">
                                                            <span class="ghost_msg_nav_item_author_name">'.get_user_meta($user_list->from_id,'nickname',true).'</span></a>
                                                        <a class="ghost_msg_nav_item_close user_'.$user_list->from_id.'" data-id="'.$user_list->from_id.'">
                                                            <span class="poi-icon fa-times fas" aria-hidden="true"></span>
                                                        </a>
                                                    </div>';
                                        }
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    <div class="ghost_msg_body">
                        <div class="ghost_msg_list_container">
                            <?php
                            $request_ = "SELECT from_id,user_id,type,content_type,msg_time FROM wp_ghost_message WHERE user_id=$user_id AND type='add_user_list' ORDER by msg_time ASC";
                            $user_lists_ = $wpdb->get_results($request_);
                            if($user_lists_ && get_user_meta($user_id,'current_user',true)){
                                echo user_msg_content($user_id,get_user_meta($user_id,'current_user',true));
                            }
                            ?>
                        </div>
                        <form class="ghost_msg_list_fm" action="javascript:;">
                            <div class="ghost_msg_list_group is-block">
                                <label class="ghost_msg_list_group_inputs">
                                    <span class="ghost_msg_list_group_icon">
                                        <span class="poi-icon fa-comment-dots fas fa-fw" aria-hidden="true"></span>
                                    </span>
                                    <span class="poi-form__group__inputs__content">
                                        <input type="text" class="ghost_setting_content_preface_control_downloadlink msg_content" placeholder="请输入信息" autocomplete="off" value=""></span>
                                </label>
                                <button type="submit" class="ghost_setting_content_btn_success input_msg">
                                    <span class="poi-icon fa-check fas fa-fw" aria-hidden="true"></span>
                                    <span class="poi-icon__text">发送</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</div>
<script>
    jQuery(function ($) {
            
        // 回车发送私信
        $('.msg_input').keydown(function(event){
            if(event.keyCode==13){
                $this = $(this);
                $send_id = $this.val();
                console.log($send_id);
                $.ajax({
                    url: ghost.ajaxurl,
                    data: {
                        action: 'ajaxsendmsg',
                        send_id: $send_id
                    },
                    type:'POST',   
                    success:function(msg){
                        console.log(msg);
                        if(msg.status==1){
                            $('.ghost_msg_nav_item').removeClass('is-active');
                            $('.user_msg').append(msg.user_msg);
                            $('.ghost_msg_list_container').html(msg.user_conversation);
                            $('.user_'+$send_id).parent('.ghost_msg_nav_item').addClass('is-active');
                            $('.msg_input').val('');
                        }else if(msg.status==0){
                            $.ghostalert_error(msg.user_msg,2000,false);
                        }
                    }
                });
            }
        });
    })
</script>