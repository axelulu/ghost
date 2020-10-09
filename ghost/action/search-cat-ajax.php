<?php 
require( '../../../../wp-load.php' );
$search = $_POST['s'];
$page = isset($_POST['page']) ? $_POST['page'] : 1 ;
$cat = $_POST['cat'];
$args = array(
    's' => $search,
    'order' => 'DESC',
    'posts_per_page' => 24,
    'paged' => $page,
    'cat' => $cat,
    // 用于查询的参数或者参数集合
);
$the_query = new WP_Query( $args );
// 循环开始
if ( $the_query->have_posts() ) :?>
<div class="page-<?php echo $page ?>">
<?php while ( $the_query->have_posts() ) : $the_query->the_post();
$user_id = get_post(get_the_ID())->post_author;?>
    <div class="col-md-2 box-1 float-left">
        <article id="post-5056" class="post type-post status-publish format-standard">
            <div class="entry-thumb hover-scale">
                <a href="<?php the_permalink();?>"><img width="500" height="340" src="<?php echo ghost_get_option('post_lazy_img');?>" data-original="<?php echo catch_that_image();?>" class="lazy show" alt="<?php the_title();?>" style="display: block;"></a>
                <?php the_category() ?>
            </div>
				<a href="<?php echo ghost_get_user_author_link($user_id)?>" target="_blank" class="post_box_avatar_link" title="<?php echo get_user_meta($user_id,'nickname',true)?>">
					<img class="post_box_avatar_img" title="<?php echo get_user_meta($user_id,'nickname',true)?>" src="<?php echo get_user_meta($user_id,'ghost_user_avatar',true)?>" width="50" height="50" alt="<?php echo get_user_meta($user_id,'nickname',true)?>">
					<span class="post_box_avatar_author_name"><?php echo get_user_meta($user_id,'nickname',true)?></span>
				</a>
            <div class="entry-detail">
                <header class="entry-header">
                    <h2 class="entry-title h4"><a href="<?php the_permalink();?>" rel="bookmark"><?php the_title();?></a>
                    </h2>
                    <div class="entry-meta entry-meta-1">
                        <span class="entry-date text-muted"><i class="fas fa-bell"></i><time class="entry-date" datetime="<?php echo get_post(get_the_ID())->post_date ?>" title="<?php echo get_post(get_the_ID())->post_date ?>"><?php echo ghost_date(get_post(get_the_ID())->post_date) ?></time></span>
                        <span class="comments-link text-muted pull-right"><i class="far fa-comment"></i><a href="<?php the_permalink();?>"><?php echo get_comments_number($post->ID); ?></a></span>
                        <span class="views-count text-muted pull-right"><i class="fas fa-eye"></i><?php echo get_post_views() ?></span>
                    </div>
                </header>
            </div>
        </article>
    </div>
<?php endwhile;?>
<div class="ghost_other_more_post">
    <a data-paged="<?php echo $page ?>" data-search="<?php echo $search ?>" class="more-post ajax-morepost">更多文章 <i class="tico tico-angle-right"></i></a>
</div>
</div>
<script>

jQuery(function ($) {
    //   搜索加载更多
    $(".search .ajax-morepost").click(function(){
        $page = $('.ajax-morepost').attr('data-paged');
        $search = $('.ajax-morepost').attr('data-search');
        $catid = $('.active').find('.ghost_search_form_condition_text').attr('data-id');
        $('.ajax-morepost').attr('data-paged',++$page);
        $.ajax({
            url:ghost.ghost_ajax+"/action/search_box.php",
            type:'POST',
            data:{page: $page,search: $search,catid: $catid},
            success:function(msg){
                if(msg.status==0){
                    $('.ajax-morepost').html("加载完毕");
                }else{
                    $('#ghost_box_1').append(msg);
                    $('.page-'+($page)+' img.lazy').lazyload({
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
endif;
// 重置文章数据
wp_reset_postdata();
?>