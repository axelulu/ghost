<?php 

// 发起私信
function ajax_send_msg()
{
    header('Content-type:application/json; Charset=utf-8');
    global $current_user;
    $userid = $current_user->ID;
    if(!is_user_logged_in()){ exit;}
    $targetid = !empty($_POST['targetid']) ? $_POST['targetid'] : null;
	if($targetid && $userid){
		ghost_add_user_msg($userid,$targetid,'add_user_list');
		update_user_meta($userid,'current_user',$targetid);
		$result['status']	= 1;
		$result['msg'] = '发起成功';
	}else{
		$result['status']	= 0;
		$result['msg'] = '发起失败';
	}

	echo json_encode( $result );
	exit;
}
add_action('wp_ajax_ajax_send_msg', 'ajax_send_msg');
add_action('wp_ajax_nopriv_ajax_send_msg', 'ajax_send_msg');


// 添加私信内容
function ghost_add_user_msg($user_id,$from_id,$type,$content_type=null,$read=0){
	global $wpdb;
	$table_name=$wpdb->prefix.'ghost_message';
	$msg_time=current_time('mysql');
	if($type=='add_user_list'){
			$request_ = "SELECT from_id,user_id,type,content_type,msg_time FROM wp_ghost_message WHERE user_id=$user_id AND from_id=$from_id AND type='add_user_list'";
			$user_lists_ = $wpdb->get_results($request_);
			if(!$user_lists_){
				$wpdb->query( "INSERT INTO $table_name (user_id,from_id,type,msg_time,content_type,status) VALUES ('$user_id','$from_id','$type','$msg_time','$content_type','$read')" );
			}
	}else{
        $wpdb->query( "INSERT INTO $table_name (user_id,from_id,type,msg_time,content_type,user_read,from_read,status) VALUES ('$user_id','$from_id','$type','$msg_time','$content_type',1,0,1)" );
	}
}

// 私信标记已读
function update_add_user_msg($user_id,$from_id,$type,$user_read=null,$from_read=null){
		global $wpdb;
    if($user_id){
			$wpdb->update('wp_ghost_message' , array( 'from_read' => '1' ), array( 'from_id' => $user_id, 'type'=>$type ) );
    }
}

// 通知标记已读
function update_add_user_notice($user_id){
		global $wpdb;
    if($user_id){
			$wpdb->update('wp_ghost_msg' , array( 'status' => '1' ), array( 'user_id' => $user_id, 'status'=>'0' ) );
    }
}

// 通知标记已读
function get_add_user_notice_read($user_id){
		global $wpdb;
    if($user_id){
			$request = "SELECT user_id,status FROM wp_ghost_msg WHERE user_id='$user_id' AND status=0 ";
			$num = count($wpdb->get_results($request));
			return $num;
    }
}

// 获取未读消息数量
function get_unread_num($user_id){
    
    if($user_id){
        global $wpdb;
			$request = "SELECT user_id,from_read,status FROM wp_ghost_message WHERE type='add_user_content' AND from_id='$user_id' AND from_read=0 ";
			$num = count($wpdb->get_results($request));
			return $num;
    }
}

//判断是否为当前消息
function is_active($user_id,$send_id){
    $is_active = '';
    if(get_user_meta($user_id,'current_user',true) && get_user_meta($user_id,'current_user',true) == $send_id){
        $is_active = 'is-active';
    }
    return $is_active;
}

// 查询私信
function query_msg($user_id){
    global $wpdb;
    $request = "SELECT from_id,user_id,type,content_type,msg_time FROM wp_ghost_message WHERE user_id=$user_id AND type='add_user_list'";
    $query = $wpdb->get_results($request);
    return $query;
}

// 循环私信内容
function user_msg_content($user_id,$send_id){
    global $wpdb;
	update_add_user_msg($user_id,$send_id,'add_user_content',1);
    $request = "SELECT from_id,user_id,type,content_type,msg_time FROM wp_ghost_message WHERE (user_id=$user_id AND from_id=$send_id) OR (user_id=$send_id AND from_id=$user_id) ORDER by msg_time ASC";
    $user_lists = $wpdb->get_results($request);
    $html = '';
    foreach ( $user_lists as $user_list ) {
        if($user_list->type=='add_user_content'){
            if($user_list->user_id==$user_id){$right_msg = 'right_msg';}else{$right_msg = '';};
            $html.= '<div class="'.$right_msg.' ghost_msg_list">
                        <a class="ghost_msg_list_thumbnail" href="'.ghost_get_user_author_link($user_list->user_id).'" target="_blank">
                            <img title="'.get_user_meta($user_list->user_id,'nickname',true).'" alt="'.get_user_meta($user_list->user_id,'nickname',true).'" class="ghost_msg_list_thumbnail_avatar_img" src="'.get_user_meta($user_list->user_id,'ghost_user_avatar',true).'" width="40" height="40"></a>
                        <div class="ghost_msg_list_body">
                            <div class="ghost_msg_list_meta">
                                <span class="ghost_msg_list_meta_item ghost_msg_list_meta_name">'.get_user_meta($user_list->user_id,'nickname',true).'</span>
                                <span class="ghost_msg_list_meta_item ghost_msg_list_meta_uid">(uid:'.$user_list->user_id.')</span>
                                <span class="ghost_msg_list_meta_item ghost_msg_list_meta_date">'.$user_list->msg_time.'</span></div>
                            <div class="ghost_msg_list_content">'.$user_list->content_type.'</div></div>
                    </div>';
        }
    }
    return $html;
}

// 回车添加私信列表
function ajaxsendmsg()
{
    global $current_user,$wpdb;
    $user_id = $current_user->ID;
    $send_id = $_POST['send_id'];
    $request = "SELECT from_id,user_id,type FROM wp_ghost_message WHERE user_id=$user_id AND from_id=$send_id AND type='add_user_list'";
    $user_lists = $wpdb->query($request);
    if(!is_user_logged_in()) exit;
    header( 'content-type: application/json; charset=utf-8' );
    if($user_lists){
        $result['status']	= 0;
        $result['user_msg'] = '已经添加';
    }else{
        if($_POST['send_id']){
            $email = get_userdata($send_id)->user_email;
            if(email_exists($email) && $send_id != $user_id){
                ghost_add_user_msg($user_id,$send_id,'add_user_list');
                update_user_meta($user_id,'current_user',$send_id);
                $result['status']	= 1;
                $result['user_msg'] = '<div class="ghost_msg_nav_item">
                                        <a class="ghost_msg_nav_item_author_link" title="'.get_user_meta($send_id,'nickname',true).'">
                                            <img class="ghost_msg_nav_item_author_avatar_img" src="'.get_user_meta($send_id,'ghost_user_avatar',true).'" alt="'.get_user_meta($send_id,'nickname',true).'" width="24" height="24">
                                            <span class="ghost_msg_nav_item_author_name">'.get_user_meta($send_id,'nickname',true).'</span></a>
                                        <a class="ghost_msg_nav_item_close user_'.$send_id.'" data-id="'.$send_id.'">
                                            <span class="poi-icon fa-times fas" aria-hidden="true"></span>
                                        </a>
                                    </div>';
                $result['user_conversation'] = user_msg_content($user_id,$send_id);
            }else{
                $result['status']	= 0;
                $result['user_msg'] 	= '用户错误';
            }
        }else{
            $result['status']	= 0;
            $result['user_msg'] 	= '请输入id';
        }
    }
	echo json_encode( $result );
	exit;	
}
add_action('wp_ajax_ajaxsendmsg', 'ajaxsendmsg');
add_action('wp_ajax_nopriv_ajaxsendmsg', 'ajaxsendmsg');

// 删除私信
function ajaxdelmsg()
{
    global $current_user,$wpdb;
    $user_id = $current_user->ID;
    $send_id = $_POST['send_id'];
    $request = "DELETE FROM wp_ghost_message WHERE user_id=$user_id AND type='add_user_list' AND from_id=$send_id";
    $user_lists = $wpdb->query($request);
    if(!is_user_logged_in()) exit;
    header( 'content-type: application/json; charset=utf-8' );
    if(!$user_lists){
        $result['status']	= 0;
        $result['user_msg'] = '删除失败';
    }else{
        if($_POST['is_active']){
            update_user_meta($user_id,'current_user','');
        }
        $result['status']	= 1;
        $result['user_msg'] = '已经删除';
    }
	echo json_encode( $result );
	exit;
}
add_action('wp_ajax_ajaxdelmsg', 'ajaxdelmsg');
add_action('wp_ajax_nopriv_ajaxdelmsg', 'ajaxdelmsg');

// 给用户发送私信
function ajaxsubmitmsg()
{
    global $current_user,$wpdb;
    $user_id = $current_user->ID;
    $send_id = $_POST['send_id'];
    $content = $_POST['content'];
    $daily_msg_num = ghost_get_option('daily_msg_num') ? ghost_get_option('daily_msg_num') : 30;
    if(!is_user_logged_in()) exit;
    if($send_id){
    	if(get_user_meta($user_id,'daily_msg_num',true)<$daily_msg_num){
        if($content){
            ghost_add_user_msg($user_id,$send_id,'add_user_content',$content);
            ghost_add_user_msg($send_id,$user_id,'add_user_list');
            update_user_meta($user_id,'current_user',$send_id);
            if(get_user_meta($user_id,'daily_msg_num',true)){
					update_user_meta($user_id,'daily_msg_num',get_user_meta($user_id,'daily_msg_num',true)+1);
             }else{
					update_user_meta($user_id,'daily_msg_num',1);
             }
            $message_email_msg = get_user_meta($send_id,'message_email_msg',true);
            $message_email_msg = isset($message_email_msg) ? $message_email_msg : ghost_get_option('message_email_msg');
            $send_meta = get_user_by( 'id', $send_id );
            if($message_email_msg){
                sendMail($send_meta->user_email, '私信提醒', '用户：<a href="'.ghost_get_user_author_link($send_id).'">'.get_user_meta($send_id,'nickname',true).'</a>给您发送了一条私信！');
            }
            $result['status'] = 1;
            $result['user_msg'] = '<div class="ghost_msg_list">
                                        <a class="ghost_msg_list_thumbnail" href="'.ghost_get_user_author_link($user_id).'" target="_blank">
                                            <img title="'.get_user_meta($user_id,'nickname',true).'" alt="'.get_user_meta($user_id,'nickname',true).'" class="ghost_msg_list_thumbnail_avatar_img" src="'.get_user_meta($user_id,'ghost_user_avatar',true).'" width="40" height="40"></a>
                                        <div class="ghost_msg_list_body">
                                            <div class="ghost_msg_list_meta">
                                                <span class="ghost_msg_list_meta_item ghost_msg_list_meta_name">'.get_user_meta($user_id,'nickname',true).'</span>
                                                <span class="ghost_msg_list_meta_item ghost_msg_list_meta_uid">(uid:'.$user_id.')</span>
                                                <span class="ghost_msg_list_meta_item ghost_msg_list_meta_date">'.get_the_date('Y-n-j G:i:s').'</span></div>
                                            <div class="ghost_msg_list_content">'.$content.'</div></div>
                                    </div>';
        }else{
            $result['status'] = 3;
            $result['user_msg'] = '请填写内容';
        }
		}else{
		$result['status'] = 2;
		$result['user_msg'] = '今日发送达上限';
		}
    }else{
        $result['status'] = 0;
        $result['user_msg'] = '错误';
    }
    header( 'content-type: application/json; charset=utf-8' );
	echo json_encode( $result );
	exit;
}
add_action('wp_ajax_ajaxsubmitmsg', 'ajaxsubmitmsg');
add_action('wp_ajax_nopriv_ajaxsubmitmsg', 'ajaxsubmitmsg');

// 用戶私信切換
function ajax_change_user_content()
{
    global $current_user,$wpdb;
    $user_id = $current_user->ID;
    $send_id = $_POST['userid'];
    if(!is_user_logged_in()) exit;
    if($send_id){
			update_user_meta($user_id,'current_user',$send_id);
			$result['status'] = 1;
			$result['user_msg'] = user_msg_content($user_id,$send_id);
    }else{
        $result['status'] = 0;
        $result['user_msg'] = '错误';
    }
    header( 'content-type: application/json; charset=utf-8' );
	echo json_encode( $result );
	exit;
}
add_action('wp_ajax_ajax_change_user_content', 'ajax_change_user_content');
add_action('wp_ajax_nopriv_ajax_change_user_content', 'ajax_change_user_content');
