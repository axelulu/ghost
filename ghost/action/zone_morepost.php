<?php 
require( '../../../../wp-load.php' );
global $current_user;$user_id = $current_user->ID;
$page = isset($_POST['page']) ? $_POST['page'] : 1 ;
$type = isset($_POST['type']) ? $_POST['type'] : '' ;
$zonepost='';
$page++;
$zonepost='';
//第一次进入,需要缓存
if(ghost_get_post_type($type)=='ghost_focus'){
	$request = "SELECT fans_id,user_id FROM wp_ghost_fans WHERE fans_id=$user_id";
	$focus = $wpdb->get_results($request);
	$users='';
	if($focus){
		foreach($focus as $focuss ){
			$users .= $focuss->user_id.',';
		}
		$args = array(
			'order' => 'DESC',
			'orderby' => 'date',
			'posts_per_page' => 12,
			'paged' => $page,
			'author' => $users,
			// 用于查询的参数或者参数集合
		);
	}else{
		$args = array(
			// 用于查询的参数或者参数集合
		);
	}
}else{
	$args = array(
		'order' => 'DESC',
		'orderby' => 'date',
		'posts_per_page' => 12,
		'paged' => $page,
		'meta_key' => ghost_get_post_type($type),
		// 用于查询的参数或者参数集合
	);
}
$the_query = new WP_Query( $args );
// 循环开始
if ( $the_query->have_posts() ) :
echo '<div class="page-'.$page.'">';
while ( $the_query->have_posts() ) : $the_query->the_post();
	$user_id = get_post(get_the_ID())->post_author;
	echo '<div class="col-md-12 box-1 clearfix float-left">
	<div class="col-md-3 zone_author float-left">
		<div style="width:70%" class="ghost_user_item">
			<a class="ghost_user_item_link" href="'.ghost_get_user_author_link($user_id).'">
				<img title="'.get_user_meta($user_id,'nickname',true).'" alt="'.get_user_meta($user_id,'nickname',true).'" class="ghost_user_item_avatar_img" src="'.get_user_meta($user_id,'ghost_user_avatar',true).'" width="100" height="100"></a>
			<a class="ghost_user_item_author_link" href="'.ghost_get_user_author_link($user_id).'" target="_self" title="'.get_user_meta($user_id,'nickname',true).'">
				<span class="ghost_user_item_author_name">'.get_user_meta($user_id,'nickname',true).'</span></a>
				<div class="ghost_author_level">
					<span class="ghost_author_poi-label" style="background-color: #e1b32a">'.ghost_user_type($user_id).'</span>
				</div>
		</div>
	</div>
	<article id="post-5056" class="col-md-9 post type-post status-publish format-standard float-right">
		<div class="entry-thumb hover-scale">
					<a href="'.get_permalink().'"><img width="500" height="340" src="'.ghost_get_option('post_lazy_img').'" data-original="'.catch_that_image().'" class="lazy show" alt="'.get_the_title().'" style="display: block;"></a>
					<ul class="post-categories">
					<li><a href="'.get_permalink().'" rel="category tag">'.get_the_category()[0]->cat_name.'</a></li></ul>
					</div>
		<div class="entry-detail">
			<header class="entry-header">
				<h2 class="entry-title h4"><a href="'.get_permalink().'" rel="bookmark">'.get_the_title().'</a>
				</h2>
				<div class="entry-meta entry-meta-1">
					<span class="entry-date text-muted"><i class="fas fa-bell"></i><time class="entry-date" datetime="'.get_post(get_the_ID())->post_date.'" title="'.get_post(get_the_ID())->post_date.'">'.ghost_date(get_post(get_the_ID())->post_date).'</time></span>
					<span class="comments-link text-muted pull-right"><i class="far fa-comment"></i><a href="'.get_permalink().'">'.get_comments_number($post->ID).'</a></span>
					<span class="views-count text-muted pull-right"><i class="fas fa-eye"></i>'.get_post_views().'</span>
				</div>
			</header>
		</div>
	</article>
	</div>';
endwhile;
echo '</div>';
else:
	header( 'content-type: application/json; charset=utf-8' );
	$result['status']	= 0;
	echo json_encode( $result );
	exit;
endif;
// 重置文章数据
wp_reset_postdata();
?>