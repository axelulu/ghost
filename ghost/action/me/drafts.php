<?php
require( '../../../../../wp-load.php' );
global $current_user;
$user_id = $current_user->ID;
$deflink = empty(ghost_get_option('ghost_site_me_link')) ? 'me' : ghost_get_option('ghost_site_me_link');
?>
<div class="ghost_setting_content">
    <div class="drafts ghost_setting_content_container">
        <fieldset class="ghost_setting_content_item">
            <legend class="ghost_setting_content_item_title">
                <span class="ghost_setting_content_primary">
                    <span class="poi-icon fa-user-circle fas fa-fw" aria-hidden="true"></span>
                    <span class="ghost_setting_content_text">我的稿件</span></span>
            </legend>
            <div class="ghost_setting_content_item_content">
                <div class="ghost_setting_content_preface">
                    <p>您可以在这个页面查看您发布过的帖子，鼠标悬浮即可见编辑按钮。</p>
                    <p>重新编辑帖子后需要二次审核，请谨慎编辑哦！</p>
                </div>
                <div class="ghost_setting_content_my_avatar">
                    <section class="ghost_drafts_posts_table_section">
                    <?php $args = array(
                        'author' => $user_id,
                        'order' => 'DESC',
                        'posts_per_page' => 12,
                        'paged' => 1,
                        'post_status' => array(
                            'pending', // -等待复审的文章
                            'draft', // - 处于草稿状态的文章
                            'publish', // - 处于发布状态的文章
                        ),
                        // 用于查询的参数或者参数集合
                    );
                    $the_query = new WP_Query( $args );
                    // 循环开始
                    if ( $the_query->have_posts() ) :?>
                        <table class="ghost_drafts_posts_table">
                            <thead>
                                <tr>
                                    <th>封面</th>
                                    <th>标题</th>
                                    <th>操作</th>
                                    <th>状态</th>
                                    <th>类型</th>
                                    <th>日期</th>
                                    <th>评论</th>
                                    <th>下载</th>
                                    <th>点赞</th></tr>
                            </thead>
                            <tbody>
                                <?php 
                                while ( $the_query->have_posts() ) : $the_query->the_post();?>
                                    <tr>
                                        <td class="ghost_drafts_thumbnail" title="封面">
                                            <a class="ghost_drafts_item_thumbnail" href="<?php the_permalink();?>" target="_blank">
                                                <img class="ghost_drafts_thumbnail_img" src="<?php echo catch_that_image();?>" alt="封面" width="320" height="180"></a>
                                        </td>
                                        <td class="ghost_drafts_postTitle" style="width: 32%;" title="标题">
                                            <a class="ghost_drafts_item_title" href="<?php the_permalink();?>" target="_blank" title="查看文章"><?php the_title();?></a></td>
                                        <td class="ghost_drafts_control" title="操作">
                                            <div class="ghost_drafts_item_action">
                                                <a href="<?php echo home_url('/'.$deflink.'/edit_post?post_id='.get_the_ID()); ?>" target="_blank" title="(编辑)" class="inn-account__my-posts__item__action__link">
                                                    <span class="poi-icon fa-edit fas fa-fw" aria-hidden="true"></span>
                                                    <span class="poi-icon__text">(编辑)</span></a>
                                            </div>
                                        </td>
                                        <td class="ghost_drafts_status" title="状态"><?php if(get_post_status(get_the_ID())=='publish'){echo '已发布';}else if(get_post_status(get_the_ID())=='pending'){echo '待审核';}else if(get_post_status(get_the_ID())=='draft'){echo '草稿';} ?></td>
                                        <td class="ghost_drafts_format" title="类型">标准</td>
                                        <td class="ghost_drafts_date" title="日期"><?php echo ghost_date(get_the_date('Y-n-j G:i:s')) ?></td>
                                        <td class="ghost_drafts_comments" title="评论">
                                            <span class="poi-icon fa-comments fas fa-fw" aria-hidden="true"></span><?php echo get_comments_number($post->ID); ?></td>
                                        <td class="ghost_drafts_downloads" title="下载">
                                            <span class="poi-icon fa-cloud-download fas fa-fw" aria-hidden="true"></span>0</td>
                                        <td class="ghost_drafts_like" title="文章点赞">
                                            <span class="poi-icon fa-thumbs-o-up fas fa-fw" aria-hidden="true"></span>0</td>
                                    </tr>
                                <?php endwhile;
                                // 重置文章数据
                                wp_reset_postdata();
                                ?>
                            </tbody>
                        </table>
                        <div class="ghost_drafts_more_post">
                            <a data-paged="<?php echo get_query_var('paged') ?>" data-cat="<?php echo get_query_var('cat') ?>" class="more-post ajax-morepost">更多文章 <i class="tico tico-angle-right"></i></a>
                        </div>
                        <script>
                            jQuery(function ($) {
                                $(".ajax-morepost").click(function(){
                                    $page = $('.ajax-morepost').attr('data-paged');
                                    $('.ajax-morepost').attr('data-paged',++$page);
                                    $.ajax({
                                        url:ghost.ghost_ajax+"/action/me/drafts-post.php",
                                        type:'POST',
                                        data:{page: $page},
                                        success:function(msg){
                                            if(msg.status==0){
                                                $('.ajax-morepost').html("加载完毕");
                                            }else{
                                                $('.ghost_drafts_posts_table tbody').append(msg);
                                                $("img.lazy").lazyload({
                                                    effect: "fadeIn",
                                                });
                                            }
                                        }
                                    });
                                });
                            });
                        </script>
                    <?php else: 
                    require(get_template_directory().'/mod/error.php');
                    endif;?>
                </section>
                </div>
            </div>
        </fieldset>
    </div>
</div>