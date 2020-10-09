<?php 
require( '../../../../../wp-load.php' );
$category_id = $_POST['cat'];
$paixu = isset($_POST['paixu']) ? $_POST['paixu'] : 'data';
$page = isset($_POST['page']) ? $_POST['page'] : 1 ;
$page++;
if($paixu=='views'){
	$args = array(
    'cat' => $category_id,
    'order' => 'DESC',
    'posts_per_page' => 24,
    'paged' => $page,
		'orderby' => 'meta_value_num',
		'meta_key' => 'ghost_views',
		// 用于查询的参数或者参数集合
	);
}else{
	$args = array(
		'cat' => $category_id,
		'orderby' => $paixu,
		'order' => 'DESC',
		'posts_per_page' => 24,
		'paged' => $page,
		// 用于查询的参数或者参数集合
	);
}
$the_query = new WP_Query( $args );
// 循环开始
if ( $the_query->have_posts() ) :?>
<div class="page-<?php echo $page ?>">
<?php while ( $the_query->have_posts() ) : $the_query->the_post();
	$user_id = get_post(get_the_ID())->post_author;?>
    <div class="col-md-2 box-1 float-left">
        <article id="post-<?php echo get_the_ID() ?>" class="post type-post status-publish format-standard">
            <div class="entry-thumb hover-scale">
                <a href="<?php the_permalink();?>"><img width="500" height="340" src="<?php echo ghost_get_option('post_lazy_img');?>" data-original="<?php echo catch_that_image();?>" class="lazy show" alt="<?php the_title();?>" style="display: block;"><?php echo get_video_post_icon(get_the_ID())?></a>
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
</div>
<?php else:
	header( 'content-type: application/json; charset=utf-8' );
    $result['status']	= 0;
	echo json_encode( $result );
	exit;
endif;
// 重置文章数据
wp_reset_postdata();
?>