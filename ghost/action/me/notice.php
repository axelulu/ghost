<?php
require( '../../../../../wp-load.php' );
global $wpdb,$current_user;
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
                <div class="ghost_setting_content_preface">
                    <p>您可以在这个页面查看您发布过的帖子，鼠标悬浮即可见编辑按钮。</p>
                    <p>重新编辑帖子后需要二次审核，请谨慎编辑哦！</p>
                </div>
                <div class="ghost_notice_content_preface notice_msg">
                    <?php 
								update_add_user_notice($user_id);
                    $request = "SELECT user_id,target_id,msg_type,msg_credit,msg_time,post_id,commentid,flower_id,fans_id FROM wp_ghost_msg WHERE user_id=$user_id ORDER by msg_time DESC limit 0,16";
                    $msgs = $wpdb->get_results($request);
                    foreach ( $msgs as $msg ) {
                        if($msg->msg_type=='reg'){ ?>
                            <div class="ghost_notice_container">
                                <div class="ghost_notice_container_item">
                                    <div style="color: #4dd652;" class="ghost_notice_container_item_num"><?php echo $msg->msg_credit ?></div></div>
                                <div class="ghost_notice_container_item_icon">
                                    <span class="poi-icon fa-map-marker fas fa-fw" aria-hidden="true"></span>
                                </div>
                                <div class="ghost_notice_container_item_content">您获取了注册奖励！获得 <?php echo $msg->msg_credit ?> 金币。</div>
                                <time datetime="<?php echo $msg->msg_time ?>" title="<?php echo $msg->msg_time ?>" class="ghost_notice_container_item_date"><?php echo ghost_date($msg->msg_time) ?></time>
                            </div>
                        <?php }elseif($msg->msg_type=='forget'){?>
                            <div class="ghost_notice_container">
                                <div class="ghost_notice_container_item">
                                    <div class="ghost_notice_container_item_num"><?php echo $msg->msg_credit ?></div></div>
                                <div class="ghost_notice_container_item_icon">
                                    <span class="poi-icon fa-map-marker fas fa-fw" aria-hidden="true"></span>
                                </div>
                                <div class="ghost_notice_container_item_content">您进行了忘记密码操作!扣除 <?php echo $msg->msg_credit ?> 金币。</div>
                                <time datetime="<?php echo $msg->msg_time ?>" title="<?php echo $msg->msg_time ?>" class="ghost_notice_container_item_date"><?php echo ghost_date($msg->msg_time) ?></time>
                            </div>
                        <?php }elseif($msg->msg_type=='avatar'){ ?>
                            <div class="ghost_notice_container">
                                <div class="ghost_notice_container_item">
                                    <div class="ghost_notice_container_item_num"><?php echo $msg->msg_credit ?></div></div>
                                <div class="ghost_notice_container_item_icon">
                                    <span class="poi-icon fa-map-marker fas fa-fw" aria-hidden="true"></span>
                                </div>
                                <div class="ghost_notice_container_item_content">您修改了网站头像！扣除 <?php echo $msg->msg_credit ?> 金币。</div>
                                <time datetime="<?php echo $msg->msg_time ?>" title="<?php echo $msg->msg_time ?>" class="ghost_notice_container_item_date"><?php echo ghost_date($msg->msg_time) ?></time>
                            </div>
                        <?php }elseif($msg->msg_type=='myemail'){ ?>
                            <div class="ghost_notice_container">
                                <div class="ghost_notice_container_item">
                                    <div class="ghost_notice_container_item_num"><?php echo $msg->msg_credit ?></div></div>
                                <div class="ghost_notice_container_item_icon">
                                    <span class="poi-icon fa-map-marker fas fa-fw" aria-hidden="true"></span>
                                </div>
                                <div class="ghost_notice_container_item_content">您修改了网站邮箱！扣除 <?php echo $msg->msg_credit ?> 金币。</div>
                                <time datetime="<?php echo $msg->msg_time ?>" title="<?php echo $msg->msg_time ?>" class="ghost_notice_container_item_date"><?php echo ghost_date($msg->msg_time) ?></time>
                            </div>
                        <?php }elseif($msg->msg_type=='pwd'){ ?>
                            <div class="ghost_notice_container">
                                <div class="ghost_notice_container_item">
                                    <div class="ghost_notice_container_item_num"><?php echo $msg->msg_credit ?></div></div>
                                <div class="ghost_notice_container_item_icon">
                                    <span class="poi-icon fa-map-marker fas fa-fw" aria-hidden="true"></span>
                                </div>
                                <div class="ghost_notice_container_item_content">您修改了网站密码！扣除 <?php echo $msg->msg_credit ?> 金币。</div>
                                <time datetime="<?php echo $msg->msg_time ?>" title="<?php echo $msg->msg_time ?>" class="ghost_notice_container_item_date"><?php echo ghost_date($msg->msg_time) ?></time>
                            </div>
                        <?php }elseif($msg->msg_type=='postcomment'){ ?>
                            <div class="ghost_notice_container">
                                <div class="ghost_notice_container_item">
                                    <div style="color: #4dd652;" class="ghost_notice_container_item_num"><?php echo $msg->msg_credit ?></div></div>
                                <div class="ghost_notice_container_item_icon">
                                    <span class="poi-icon fa-map-marker fas fa-fw" aria-hidden="true"></span>
                                </div>
                                <div class="ghost_notice_container_item_content">您给文章<a href="<?php echo get_permalink($msg->post_id) ?>"><?php echo get_post($msg->post_id)->post_title ?></a>进行了评论！获得 <?php echo $msg->msg_credit ?> 金币。</div>
                                <time datetime="<?php echo $msg->msg_time ?>" title="<?php echo $msg->msg_time ?>" class="ghost_notice_container_item_date"><?php echo ghost_date($msg->msg_time) ?></time>
                            </div>
                        <?php }elseif($msg->msg_type=='usercomment'){ ?>
                            <div class="ghost_notice_container">
                                <div class="ghost_notice_container_item">
                                    <div style="color: #4dd652;" class="ghost_notice_container_item_num"><?php echo $msg->msg_credit ?></div></div>
                                <div class="ghost_notice_container_item_icon">
                                    <span class="poi-icon fa-map-marker fas fa-fw" aria-hidden="true"></span>
                                </div>
                                <div class="ghost_notice_container_item_content">您给用户<a href="<?php echo get_permalink(get_comment($msg->commentid)->comment_post_ID).'#'.$msg->commentid ?>"><?php echo get_comment_author($msg->commentid) ?></a>进行了评论！获得 <?php echo $msg->msg_credit ?> 金币。</div>
                                <time datetime="<?php echo $msg->msg_time ?>" title="<?php echo $msg->msg_time ?>" class="ghost_notice_container_item_date"><?php echo ghost_date($msg->msg_time) ?></time>
                            </div>
                        <?php }elseif($msg->msg_type=='post'){ ?>
                            <div class="ghost_notice_container">
                                <div class="ghost_notice_container_item">
                                    <div style="color: #4dd652;" class="ghost_notice_container_item_num"><?php echo $msg->msg_credit ?></div></div>
                                <div class="ghost_notice_container_item_icon">
                                    <span class="poi-icon fa-map-marker fas fa-fw" aria-hidden="true"></span>
                                </div>
                                <div class="ghost_notice_container_item_content">您成功提交了文章<a href="<?php echo get_permalink($msg->post_id) ?>"><?php echo get_post($msg->post_id)->post_title ?></a>,审核成功后即可发布！获得 <?php echo $msg->msg_credit ?> 金币。</div>
                                <time datetime="<?php echo $msg->msg_time ?>" title="<?php echo $msg->msg_time ?>" class="ghost_notice_container_item_date"><?php echo ghost_date($msg->msg_time) ?></time>
                            </div>
                        <?php }elseif($msg->msg_type=='sign_daily'){ ?>
                            <div class="ghost_notice_container">
                                <div class="ghost_notice_container_item">
                                    <div style="color: #4dd652;" class="ghost_notice_container_item_num"><?php echo $msg->msg_credit ?></div></div>
                                <div class="ghost_notice_container_item_icon">
                                    <span class="poi-icon fa-map-marker fas fa-fw" aria-hidden="true"></span>
                                </div>
                                <div class="ghost_notice_container_item_content">您成功签到！获得 <?php echo $msg->msg_credit ?> 金币。</div>
                                <time datetime="<?php echo $msg->msg_time ?>" title="<?php echo $msg->msg_time ?>" class="ghost_notice_container_item_date"><?php echo ghost_date($msg->msg_time) ?></time>
                            </div>
                        <?php }elseif($msg->msg_type=='del_flowers'){ ?>
                            <div class="ghost_notice_container">
                                <div class="ghost_notice_container_item">
                                    <div class="ghost_notice_container_item_num"><?php echo $msg->msg_credit ?></div></div>
                                <div class="ghost_notice_container_item_icon">
                                    <span class="poi-icon fa-map-marker fas fa-fw" aria-hidden="true"></span>
                                </div>
								<div class="ghost_notice_container_item_content">您取消了对<a href="<?php echo ghost_get_user_author_link($msg->flower_id)?>"><?php echo get_user_meta($msg->flower_id,'nickname',true) ?></a>的关注！扣除 <?php echo $msg->msg_credit ?> 金币。</div>
                                <time datetime="<?php echo $msg->msg_time ?>" title="<?php echo $msg->msg_time ?>" class="ghost_notice_container_item_date"><?php echo ghost_date($msg->msg_time) ?></time>
                            </div>
                        <?php }elseif($msg->msg_type=='flowers'){ ?>
                            <div class="ghost_notice_container">
                                <div class="ghost_notice_container_item">
                                    <div style="color: #4dd652;" class="ghost_notice_container_item_num"><?php echo $msg->msg_credit ?></div></div>
                                <div class="ghost_notice_container_item_icon">
                                    <span class="poi-icon fa-map-marker fas fa-fw" aria-hidden="true"></span>
                                </div>
                                <div class="ghost_notice_container_item_content">您关注了<a href="<?php echo ghost_get_user_author_link($msg->flower_id)?>"><?php echo get_user_meta($msg->flower_id,'nickname',true) ?></a>！获得 <?php echo $msg->msg_credit ?> 金币。</div>
                                <time datetime="<?php echo $msg->msg_time ?>" title="<?php echo $msg->msg_time ?>" class="ghost_notice_container_item_date"><?php echo ghost_date($msg->msg_time) ?></time>
                            </div>
                        <?php }elseif($msg->msg_type=='guajian'){ ?>
                            <div class="ghost_notice_container">
                                <div class="ghost_notice_container_item">
                                    <div class="ghost_notice_container_item_num"><?php echo $msg->msg_credit ?></div></div>
                                <div class="ghost_notice_container_item_icon">
                                    <span class="poi-icon fa-map-marker fas fa-fw" aria-hidden="true"></span>
                                </div>
												<div class="ghost_notice_container_item_content">您购买了挂件！扣除 <?php echo $msg->msg_credit ?> 金币。</div>
                                <time datetime="<?php echo $msg->msg_time ?>" title="<?php echo $msg->msg_time ?>" class="ghost_notice_container_item_date"><?php echo ghost_date($msg->msg_time) ?></time>
                            </div>
                        <?php }elseif($msg->msg_type=='buy_download_link'){ ?>
                            <div class="ghost_notice_container">
                                <div class="ghost_notice_container_item">
                                    <div class="ghost_notice_container_item_num"><?php echo $msg->msg_credit ?></div></div>
                                <div class="ghost_notice_container_item_icon">
                                    <span class="poi-icon fa-map-marker fas fa-fw" aria-hidden="true"></span>
                                </div>
												<div class="ghost_notice_container_item_content">您积分购买了<a href="<?php echo ghost_get_user_author_link($msg->user_id) ?>"><?php echo get_user_meta($msg->user_id,'nickname',true) ?></a>的文章<a href="<?php echo get_permalink($msg->post_id) ?>"><?php echo get_post($msg->post_id)->post_title ?></a>！扣除 <?php echo $msg->msg_credit ?> 金币。</div>
                                <time datetime="<?php echo $msg->msg_time ?>" title="<?php echo $msg->msg_time ?>" class="ghost_notice_container_item_date"><?php echo ghost_date($msg->msg_time) ?></time>
                            </div>
                        <?php }elseif($msg->msg_type=='earn_download_link_credit'){ ?>
                            <div class="ghost_notice_container">
                                <div class="ghost_notice_container_item">
                                    <div style="color: #4dd652;" class="ghost_notice_container_item_num"><?php echo $msg->msg_credit ?></div></div>
                                <div class="ghost_notice_container_item_icon">
                                    <span class="poi-icon fa-map-marker fas fa-fw" aria-hidden="true"></span>
                                </div>
												<div class="ghost_notice_container_item_content">您的售出了文章<a class="notice_post_link" href="<?php echo get_permalink($msg->post_id) ?>"><?php echo get_post($msg->post_id)->post_title ?></a>的下载链接给<a href="<?php echo ghost_get_user_author_link($msg->target_id) ?>"><?php echo get_user_meta($msg->target_id,'nickname',true) ?></a>！获得 <?php echo $msg->msg_credit ?> 金币。</div>
                                <time datetime="<?php echo $msg->msg_time ?>" title="<?php echo $msg->msg_time ?>" class="ghost_notice_container_item_date"><?php echo ghost_date($msg->msg_time) ?></time>
                            </div>
                        <?php }?>
                    <?php }?>
                    <div class="ghost_notice_more_post">
								<a data-paged="0" class="more-post ajax-morepost">更多文章 <i class="tico tico-angle-right"></i></a>
							</div>
                </div>
            </div>
        </fieldset>
    </div>
</div>