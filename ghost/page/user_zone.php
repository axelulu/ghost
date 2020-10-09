<?php 
/* Template Name: 个人空间 */ 
get_header();
?>
<div class="main user_credit container">
	<div class="clearfix ghost_zone_page_box">
		<main class="my_zone float-left col-lg-9">
			<div class="share_zone">
				<div class="po-form-box">
					<div data-min="5" data-max="250" data-circle="544" data-gc="544" class="po-zone-textarea b2-radius">
						<textarea type="text" placeholder="标题（选填）" class="ghost_setting_content_preface_control zone-title"></textarea>
						<textarea maxlength="250" minlength="5" placeholder="有什么新鲜事？" class="ghost_setting_content_preface_control zone-content"></textarea>
					</div>
				</div>
			</div>
			<div id="circle-zone-list" class="circle-content">
				<div class="zone-type-menu box b2-radius zone-mg-t">
					<ul>
						<li>
							<button data-type="all" class="picked zone_type">全部</button></li>
						<li>
							<button data-type="focus" class="zone_type">我的关注</button></li>
						<li>
							<button data-type="video" class="zone_type">视频</button></li>
						<li>
							<button data-type="music" class="zone_type">音乐</button></li>
						<li>
							<button data-type="words" class="zone_type">动态</button></li>
					</ul>
				</div>
				<div class="zone_list clearfix">
					<div class="zone_list_box">
						<?php 
							$zonebox = '';
							//第一次进入,需要缓存
							$args = array(
								'order' => 'DESC',
								'orderby' => 'date',
								'posts_per_page' => 12,
								'paged' => 1,
								// 用于查询的参数或者参数集合
							);
							$the_query = new WP_Query( $args );
							// 循环开始
							if ( $the_query->have_posts() ) :
							$zonebox.='<div class="page-1">';
							while ( $the_query->have_posts() ) : $the_query->the_post();
								$user_id = get_post(get_the_ID())->post_author;
								$zonebox.='<div class="col-md-12 box-1 clearfix float-left">
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
							$zonebox.='
								<div class="ghost_other_more_post">
									<a data-paged="0" class="more-post zone-morepost">更多文章 <i class="tico tico-angle-right"></i></a>
								</div></div>';
							endif;
							// 重置文章数据
							wp_reset_postdata();
							echo $zonebox;
						?>
					</div>
				</div>
			</div>
		</main>
		<aside class="my_zone float-right col-lg-3">
        <?php get_sidebar(); ?>
		</aside>
	</div>
</div>
<?php get_footer();?>