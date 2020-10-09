<?php
//redis缓存
function get_redis($key,$type,$cat_id=0,$paged=0,$tagID=0){
    $content = '';
    if(ghost_get_option('redis_switch')==true){
			//实例化redis
			$redis = new \Redis();
			//连接redis
			$redis->connect( ghost_get_option('redis_localhost') ,ghost_get_option('redis_port'));
			if($redis->get('inner_'.$key)=='yes' || !$redis->get('inner_'.$key)){
				//将数据存入redis的list中
				if($type=='menu'){
					$content = wp_nav_menu( array( 'theme_location'=>'menu-pc', 'depth' => 2, 'container_class' => 'header-menu-div','menu_class' => 'ghost_menu_ul','echo' => false,) );
				}elseif($type=='single_post'){
					//第一次进入,需要缓存
					$args = array(
						'cat' => ghost_get_post_cat_id(get_the_ID()),
						'order' => 'DESC',
						'posts_per_page' => 24,
						// 用于查询的参数或者参数集合
					);
					$the_query = new WP_Query( $args );
					// 循环开始
					if ( $the_query->have_posts() ) :
					$content .= '<div class="single_more_posts">';
					while ( $the_query->have_posts() ) : $the_query->the_post();
					$user_id2 = get_post(get_the_ID())->post_author;
						$content .= '<div class="col-md-3 box-1 float-left">
									<article class="post type-post status-publish format-standard">
										<div class="entry-thumb hover-scale">
											<a href="'.get_permalink().'"><img width="500" height="340" src="'.catch_that_image().'" class="show" alt="'.get_the_title().'" style="display: block;"></a>
															<ul class="post-categories">
															<li><a href="'.get_permalink().'" rel="category tag">'.get_the_category()[0]->cat_name.'</a></li></ul>
										</div>
														<a href="'.ghost_get_user_author_link($user_id2).'" target="_blank" class="post_box_avatar_link" title="'.get_user_meta($user_id2,'nickname',true).'">
															<img class="post_box_avatar_img" title="'.get_user_meta($user_id2,'nickname',true).'" src="'.get_user_meta($user_id2,'ghost_user_avatar',true).'" width="50" height="50" alt="'.get_user_meta($user_id2,'nickname',true).'">
															<span class="post_box_avatar_author_name">'.get_user_meta($user_id2,'nickname',true).'</span>
														</a>
										<div class="entry-detail">
											<header class="entry-header">
												<h2 class="entry-title h4"><a href="'.get_permalink().'" rel="bookmark">'.get_the_title().'</a>
												</h2>
												<div class="entry-meta entry-meta-1">
													<span class="entry-date text-muted"><i class="fas fa-bell"></i><time class="entry-date" datetime="'.get_the_date('Y-n-j').'" title="'.get_the_date('Y-n-j').'">'.ghost_date(get_the_date('Y-n-j G:i:s')).'</time></span>
													<span class="comments-link text-muted pull-right"><i class="far fa-comment"></i><a href="'.get_permalink().'">'.get_comments_number($post->ID).'</a></span>
													<span class="views-count text-muted pull-right"><i class="fas fa-eye"></i>'.get_post_views().'</span>
												</div>
											</header>
										</div>
									</article>
								</div>';
					endwhile;
					$content .= '</div>';
					endif;
					// 重置文章数据
					wp_reset_postdata();
				}elseif($type=='single_content'){
					$content = do_shortcode(convert_smilies(wpautop(get_post(get_the_ID())->post_content)));
				}elseif($type=='post_rank'){
					//第一次进入,需要缓存
					$args = array(
						'order' => 'DESC',
						'posts_per_page' => ghost_get_option('page_postrank_num'),
						'paged' => 1,
						'orderby' => 'data',
						// 用于查询的参数或者参数集合
					);
					$the_query = new WP_Query( $args );
					$content.='<div class="page-1">';
					while ( $the_query->have_posts() ) : $the_query->the_post();
						$content.='<div class="col-md-2 box-1 float-left">
							<article id="post-'.get_the_ID().'" class="post type-post status-publish format-standard">
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
					$content.='</div>';
					// 重置文章数据
					wp_reset_postdata();
				}elseif($type=='user_rank'){
					$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
					$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
					// WP_User_Query参数
					$authors = new WP_User_Query( array ( 
						'meta_key' => 'sign_daily',
						'meta_value' =>$beginToday,
						'meta_compare'=>'>=',
						'order'	 => 'DESC ',
					));
					$authors = $authors->get_results();
					if(!empty($authors)){
						foreach($authors as $author ){ 
							$times = !empty(get_user_meta($author->ID,'sign_daily',true)) ? ghost_date(date("Y-m-d H:i:s",get_user_meta($author->ID,'sign_daily',true))) : 0;
							$days = !empty(get_user_meta($author->ID,'sign_daily_num',true)) ? get_user_meta($author->ID,'sign_daily_num',true) : 0;
							$credit = !empty(get_user_meta($author->ID,'user_credit',true)) ? get_user_meta($author->ID,'user_credit',true) : 0;
							$content .= '<div class="ghost_user_item float-left">
								<a class="ghost_user_item_link" href="'.ghost_get_user_author_link($author->ID).'">
									<img title="'.get_user_meta($author->ID,'nickname',true).'" alt="'.get_user_meta($author->ID,'nickname',true).'" class="ghost_user_item_avatar_img" src="'.get_user_meta($author->ID,'ghost_user_avatar',true).'" width="100" height="100"></a>
								<a class="ghost_user_item_author_link" href="'.ghost_get_user_author_link($author->ID).'" target="_self" title="'.get_user_meta($author->ID,'nickname',true).'">
									<span class="ghost_user_item_author_name">'.get_user_meta($author->ID,'nickname',true).'</span></a>
												<div class="ghost_user_item_author_credit" title="'.date("Y-m-d H:i:s",get_user_meta($author->ID,'sign_daily',true)).'">签到时间：'.$times.'</div>
												<div style="top: 33px;" class="ghost_user_item_author_credit">连续签到：'.$days.'天</div>
												<div style="top: 47px;" class="ghost_user_item_author_credit">积分：'.$credit.'</div>
							</div>';
						}
					}else{
						require(get_template_directory().'/mod/error.php');
					}
				}elseif($type=='archive'){
					//第一次进入,需要缓存
					$args = array(
						'tag_id' => $tagID,
						'order' => 'DESC',
						'posts_per_page' => 24,
						'paged' => $paged,
						// 用于查询的参数或者参数集合
					);
					$the_query = new WP_Query( $args );
					// 循环开始
					if ( $the_query->have_posts() ) :
					$content.='<div class="page-<?php echo $paged+1 ?>">';
					while ( $the_query->have_posts() ) : $the_query->the_post();
					$user_id = get_post(get_the_ID())->post_author;
						$content.='<div class="col-md-2 box-1 float-left">
							<article id="post-'.get_the_ID().'" class="post type-post status-publish format-standard">
								<div class="entry-thumb hover-scale">
											<a href="'.get_permalink().'"><img width="500" height="340" src="'.ghost_get_option('post_lazy_img').'" data-original="'.catch_that_image().'" class="lazy show" alt="'.get_the_title().'" style="display: block;">'.get_video_post_icon(get_the_ID()).'</a>
											<ul class="post-categories">
											<li><a href="'.get_permalink().'" rel="category tag">'.get_the_category()[0]->cat_name.'</a></li></ul>
											</div>
											<a href="'.ghost_get_user_author_link($user_id).'" target="_blank" class="post_box_avatar_link" title="'.get_user_meta($user_id,'nickname',true).'">
												<img class="post_box_avatar_img" title="'.get_user_meta($user_id,'nickname',true).'" src="'.get_user_meta($user_id,'ghost_user_avatar',true).'" width="50" height="50" alt="'.get_user_meta($user_id,'nickname',true).'">
												<span class="post_box_avatar_author_name">'.get_user_meta($user_id,'nickname',true).'</span>
											</a>
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
					$content.='</div>';
					else:
						require(get_template_directory().'/mod/error.php');
					endif;
					// 重置文章数据
					wp_reset_postdata();
				}elseif($type=='popular'){
					//幻灯片
					$args = array(
						'order' => 'DESC',
						'posts_per_page' => 16,
						'paged' => 1,
						'orderby' => 'modified',
						// 用于查询的参数或者参数集合
					);
					$the_query = new WP_Query( $args );
					// 循环开始
					if ( $the_query->have_posts() ) :
					while ( $the_query->have_posts() ) : $the_query->the_post();
						$content.='<a class="ghost-slideshow__item__link ghost-popular-link" href="'.get_permalink().'" style="background-color: rgba(225,225,225,.3);">
										<img src="'.ghost_get_option('post_lazy_img').'" data-original="'.catch_that_image().'" alt="'.get_the_title().'" class="lazy ghost-popular-img show" style="background-color: rgb(245, 217, 215); display: inline;">
										<div class="ghost-popular-mask"></div>
										<h3 class="ghost-popular-title">
											<span class="ghost-popular-text">'.get_the_title().'</span>
										</h3>
									</a>';
					endwhile;
					endif;
					// 重置文章数据
					wp_reset_postdata();
				}elseif($type=='headbox'){
					//第一次进入,需要缓存
					$args = array(
						'cat' => $cat_id,
						'order' => 'DESC',
						'posts_per_page' => 12,
						'paged' => 1,
						// 用于查询的参数或者参数集合
					);
					$the_query = new WP_Query( $args );
					// 循环开始
					if ( $the_query->have_posts() ) :
					while ( $the_query->have_posts() ) : $the_query->the_post();
					$user_id = get_post(get_the_ID())->post_author;
						$content.='<div class="col-md-2 box-1 float-left">
							<article id="post-'.get_the_ID().'" class="post type-post status-publish format-standard">
								<div class="entry-thumb hover-scale">
											<a href="'.get_permalink().'"><img width="500" height="340" src="'.ghost_get_option('post_lazy_img').'" data-original="'.catch_that_image().'" class="lazy show" alt="'.get_the_title().'" style="display: block;">'.get_video_post_icon(get_the_ID()).'</a>
											<ul class="post-categories">
											<li><a href="'.get_permalink().'" rel="category tag">'.get_the_category()[0]->cat_name.'</a></li></ul>
											</div>
											<a href="'.ghost_get_user_author_link($user_id).'" target="_blank" class="post_box_avatar_link" title="'.get_user_meta($user_id,'nickname',true).'">
												<img class="post_box_avatar_img" title="'.get_user_meta($user_id,'nickname',true).'" src="'.get_user_meta($user_id,'ghost_user_avatar',true).'" width="50" height="50" alt="'.get_user_meta($user_id,'nickname',true).'">
												<span class="post_box_avatar_author_name">'.get_user_meta($user_id,'nickname',true).'</span>
											</a>
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
					endif;
					// 重置文章数据
					wp_reset_postdata();
				}elseif($type=='headbox2'){
					//第一次进入,需要缓存
					$args = array(
						'cat' => $cat_id,
						'order' => 'DESC',
						'posts_per_page' => 12,
						'paged' => 1,
						// 用于查询的参数或者参数集合
					);
					$the_query = new WP_Query( $args );
					// 循环开始
					if ( $the_query->have_posts() ) :
					while ( $the_query->have_posts() ) : $the_query->the_post();
					$user_id = get_post(get_the_ID())->post_author;
						$content.='<div class="col-md-2 box-2 float-left">
							<article id="post-'.get_the_ID().'" class="post type-post status-publish format-standard">
								<div class="entry-thumb hover-scale">
											<a href="'.get_permalink().'"><img width="500" height="340" src="'.ghost_get_option('post_lazy_img').'" data-original="'.catch_that_image().'" class="lazy show" alt="'.get_the_title().'" style="display: block;"></a>
											<ul class="post-categories">
											<li><a href="'.get_permalink().'" rel="category tag">'.get_the_category()[0]->cat_name.'</a></li></ul>
											</div>
											<a href="'.ghost_get_user_author_link($user_id).'" target="_blank" class="post_box_avatar_link" title="'.get_user_meta($user_id,'nickname',true).'">
												<img class="post_box_avatar_img" title="'.get_user_meta($user_id,'nickname',true).'" src="'.get_user_meta($user_id,'ghost_user_avatar',true).'" width="50" height="50" alt="'.get_user_meta($user_id,'nickname',true).'">
												<span class="post_box_avatar_author_name">'.get_user_meta($user_id,'nickname',true).'</span>
											</a>
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
					endif;
					// 重置文章数据
					wp_reset_postdata();
				}elseif($type=='headbox3'){
					//第一次进入,需要缓存
					$args = array(
						'cat' => $cat_id,
						'order' => 'DESC',
						'posts_per_page' => 6,
						'paged' => 1,
						// 用于查询的参数或者参数集合
					);
					$the_query = new WP_Query( $args );
					// 循环开始
					if ( $the_query->have_posts() ) :
					while ( $the_query->have_posts() ) : $the_query->the_post();
					$user_id = get_post(get_the_ID())->post_author;
						$content.='<div class="col-md-2 box-1 float-left">
							<article id="post-'.get_the_ID().'" class="post type-post status-publish format-standard">
								<div class="entry-thumb hover-scale">
											<a href="'.get_permalink().'"><img width="500" height="340" src="'.ghost_get_option('post_lazy_img').'" data-original="'.catch_that_image().'" class="lazy show" alt="'.get_the_title().'" style="display: block;">'.get_video_post_icon(get_the_ID()).'</a>
											<ul class="post-categories">
											<li><a href="'.get_permalink().'" rel="category tag">'.get_the_category()[0]->cat_name.'</a></li></ul>
											</div>
											<a href="'.ghost_get_user_author_link($user_id).'" target="_blank" class="post_box_avatar_link" title="'.get_user_meta($user_id,'nickname',true).'">
												<img class="post_box_avatar_img" title="'.get_user_meta($user_id,'nickname',true).'" src="'.get_user_meta($user_id,'ghost_user_avatar',true).'" width="50" height="50" alt="'.get_user_meta($user_id,'nickname',true).'">
												<span class="post_box_avatar_author_name">'.get_user_meta($user_id,'nickname',true).'</span>
											</a>
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
					endif;
					// 重置文章数据
					wp_reset_postdata();
				}elseif($type=='cat'){
					//第一次进入,需要缓存
					$args = array(
						'cat' => $cat_id,
						'order' => 'DESC',
						'posts_per_page' => 24,
						'paged' => $paged,
						// 用于查询的参数或者参数集合
					);
					$the_query = new WP_Query( $args );
					// 循环开始
					if ( $the_query->have_posts() ) :
					$content.= '<div class="single_posts">';
					while ( $the_query->have_posts() ) : $the_query->the_post();
					$user_id = get_post(get_the_ID())->post_author;
						$content.='<div class="col-md-2 box-1 float-left">
							<article id="post-'.get_the_ID().'" class="post type-post status-publish format-standard">
								<div class="entry-thumb hover-scale">
											<a href="'.get_permalink().'"><img width="500" height="340" src="'.ghost_get_option('post_lazy_img').'" data-original="'.catch_that_image().'" class="lazy show" alt="'.get_the_title().'" style="display: block;">'.get_video_post_icon(get_the_ID()).'</a>
											<ul class="post-categories">
											<li><a href="'.get_permalink().'" rel="category tag">'.get_the_category()[0]->cat_name.'</a></li></ul>
											</div>
											<a href="'.ghost_get_user_author_link($user_id).'" target="_blank" class="post_box_avatar_link" title="'.get_user_meta($user_id,'nickname',true).'">
												<img class="post_box_avatar_img" title="'.get_user_meta($user_id,'nickname',true).'" src="'.get_user_meta($user_id,'ghost_user_avatar',true).'" width="50" height="50" alt="'.get_user_meta($user_id,'nickname',true).'">
												<span class="post_box_avatar_author_name">'.get_user_meta($user_id,'nickname',true).'</span>
											</a>
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
					$content.= '<div class="ghost_other_more_post">
								<a data-paged="'.get_query_var('paged').'" data-cat="'.get_query_var('cat').'" class="more-post ajax-morepost">更多文章 <i class="tico tico-angle-right"></i></a>
							</div></div>';
					else:
						require(get_template_directory().'/mod/error.php');
					endif;
					// 重置文章数据
					wp_reset_postdata();
				}
				$contentjson=json_encode($content);
				$redis->del($key);//把键值删除，防止重复
				$redis->lPush($key, $contentjson);
				$hshs = $redis->set('inner_'.$key, 'no',(int)ghost_get_option('redis_past_time')); //设置键值有效期为60秒
			}else{
				//从redis中取出数据
				$content=$redis->lRange($key, 0, -1);
				$content=json_decode($content[0],true);
			}
	}else{
		if($type=='menu'){
			$content = wp_nav_menu( array( 'theme_location'=>'menu-pc', 'depth' => 2, 'container_class' => 'header-menu-div','menu_class' => 'ghost_menu_ul','echo' => false,) );
		}elseif($type=='single_post'){
			//第一次进入,需要缓存
			$args = array(
				'cat' => ghost_get_post_cat_id(get_the_ID()),
				'order' => 'DESC',
				'posts_per_page' => 24,
				// 用于查询的参数或者参数集合
			);
			$the_query = new WP_Query( $args );
			// 循环开始
			if ( $the_query->have_posts() ) :
			$content .= '<div class="single_more_posts">';
			while ( $the_query->have_posts() ) : $the_query->the_post();
			$user_id2 = get_post(get_the_ID())->post_author;
				$content .= '<div class="col-md-3 box-1 float-left">
							<article class="post type-post status-publish format-standard">
								<div class="entry-thumb hover-scale">
									<a href="'.get_permalink().'"><img width="500" height="340" src="'.catch_that_image().'" class="show" alt="'.get_the_title().'" style="display: block;"></a>
													<ul class="post-categories">
													<li><a href="'.get_permalink().'" rel="category tag">'.get_the_category()[0]->cat_name.'</a></li></ul>
								</div>
												<a href="'.ghost_get_user_author_link($user_id2).'" target="_blank" class="post_box_avatar_link" title="'.get_user_meta($user_id2,'nickname',true).'">
													<img class="post_box_avatar_img" title="'.get_user_meta($user_id2,'nickname',true).'" src="'.get_user_meta($user_id2,'ghost_user_avatar',true).'" width="50" height="50" alt="'.get_user_meta($user_id2,'nickname',true).'">
													<span class="post_box_avatar_author_name">'.get_user_meta($user_id2,'nickname',true).'</span>
												</a>
								<div class="entry-detail">
									<header class="entry-header">
										<h2 class="entry-title h4"><a href="'.get_permalink().'" rel="bookmark">'.get_the_title().'</a>
										</h2>
										<div class="entry-meta entry-meta-1">
											<span class="entry-date text-muted"><i class="fas fa-bell"></i><time class="entry-date" datetime="'.get_the_date('Y-n-j').'" title="'.get_the_date('Y-n-j').'">'.ghost_date(get_the_date('Y-n-j G:i:s')).'</time></span>
											<span class="comments-link text-muted pull-right"><i class="far fa-comment"></i><a href="'.get_permalink().'">'.get_comments_number($post->ID).'</a></span>
											<span class="views-count text-muted pull-right"><i class="fas fa-eye"></i>'.get_post_views().'</span>
										</div>
									</header>
								</div>
							</article>
						</div>';
			endwhile;
			$content .= '</div>';
			endif;
			// 重置文章数据
			wp_reset_postdata();
		}elseif($type=='single_content'){
			$content = do_shortcode(convert_smilies(wpautop(get_post(get_the_ID())->post_content)));
		}elseif($type=='post_rank'){
			//第一次进入,需要缓存
			$args = array(
				'order' => 'DESC',
				'posts_per_page' => ghost_get_option('page_postrank_num'),
				'paged' => 1,
				'orderby' => 'data',
				// 用于查询的参数或者参数集合
			);
			$the_query = new WP_Query( $args );
			$content.='<div class="page-1">';
			while ( $the_query->have_posts() ) : $the_query->the_post();
				$content.='<div class="col-md-2 box-1 float-left">
					<article id="post-'.get_the_ID().'" class="post type-post status-publish format-standard">
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
			$content.='</div>';
			// 重置文章数据
			wp_reset_postdata();
		}elseif($type=='user_rank'){
			$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
			$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
			// WP_User_Query参数
			$authors = new WP_User_Query( array ( 
				'meta_key' => 'sign_daily',
				'meta_value' =>$beginToday,
				'meta_compare'=>'>=',
				'order'	 => 'DESC ',
			));
			$authors = $authors->get_results();
			if(!empty($authors)){
				foreach($authors as $author ){ 
					$times = !empty(get_user_meta($author->ID,'sign_daily',true)) ? ghost_date(date("Y-m-d H:i:s",get_user_meta($author->ID,'sign_daily',true))) : 0;
					$days = !empty(get_user_meta($author->ID,'sign_daily_num',true)) ? get_user_meta($author->ID,'sign_daily_num',true) : 0;
					$credit = !empty(get_user_meta($author->ID,'user_credit',true)) ? get_user_meta($author->ID,'user_credit',true) : 0;
					$content .= '<div class="ghost_user_item float-left">
						<a class="ghost_user_item_link" href="'.ghost_get_user_author_link($author->ID).'">
							<img title="'.get_user_meta($author->ID,'nickname',true).'" alt="'.get_user_meta($author->ID,'nickname',true).'" class="ghost_user_item_avatar_img" src="'.get_user_meta($author->ID,'ghost_user_avatar',true).'" width="100" height="100"></a>
						<a class="ghost_user_item_author_link" href="'.ghost_get_user_author_link($author->ID).'" target="_self" title="'.get_user_meta($author->ID,'nickname',true).'">
							<span class="ghost_user_item_author_name">'.get_user_meta($author->ID,'nickname',true).'</span></a>
										<div class="ghost_user_item_author_credit" title="'.date("Y-m-d H:i:s",get_user_meta($author->ID,'sign_daily',true)).'">签到时间：'.$times.'</div>
										<div style="top: 33px;" class="ghost_user_item_author_credit">连续签到：'.$days.'天</div>
										<div style="top: 47px;" class="ghost_user_item_author_credit">积分：'.$credit.'</div>
					</div>';
				}
			}else{
				require(get_template_directory().'/mod/error.php');
			}
		}elseif($type=='archive'){
			//第一次进入,需要缓存
			$tagName = single_tag_title('',false);
			$tagObject = get_term_by('name',$tagName,'post_tag');
			$tagID = $tagObject->term_id;
			$args = array(
				'tag_id' => $tagID,
				'order' => 'DESC',
				'posts_per_page' => 24,
				'paged' => $paged,
				// 用于查询的参数或者参数集合
			);
			$the_query = new WP_Query( $args );
			// 循环开始
			if ( $the_query->have_posts() ) :
			$content.='<div class="page-<?php echo $paged+1 ?>">';
			while ( $the_query->have_posts() ) : $the_query->the_post();
			$user_id = get_post(get_the_ID())->post_author;
				$content.='<div class="col-md-2 box-1 float-left">
					<article id="post-'.get_the_ID().'" class="post type-post status-publish format-standard">
						<div class="entry-thumb hover-scale">
									<a href="'.get_permalink().'"><img width="500" height="340" src="'.ghost_get_option('post_lazy_img').'" data-original="'.catch_that_image().'" class="lazy show" alt="'.get_the_title().'" style="display: block;">'.get_video_post_icon(get_the_ID()).'</a>
									<ul class="post-categories">
									<li><a href="'.get_permalink().'" rel="category tag">'.get_the_category()[0]->cat_name.'</a></li></ul>
									</div>
									<a href="'.ghost_get_user_author_link($user_id).'" target="_blank" class="post_box_avatar_link" title="'.get_user_meta($user_id,'nickname',true).'">
										<img class="post_box_avatar_img" title="'.get_user_meta($user_id,'nickname',true).'" src="'.get_user_meta($user_id,'ghost_user_avatar',true).'" width="50" height="50" alt="'.get_user_meta($user_id,'nickname',true).'">
										<span class="post_box_avatar_author_name">'.get_user_meta($user_id,'nickname',true).'</span>
									</a>
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
			$content.='</div>';
			else:
				require(get_template_directory().'/mod/error.php');
			endif;
			// 重置文章数据
			wp_reset_postdata();
		}elseif($type=='popular'){
			//幻灯片
			$args = array(
				'order' => 'DESC',
				'posts_per_page' => 16,
				'paged' => 1,
				'orderby' => 'modified',
				// 用于查询的参数或者参数集合
			);
			$the_query = new WP_Query( $args );
			// 循环开始
			if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : $the_query->the_post();
				$content.='<a class="ghost-slideshow__item__link ghost-popular-link" href="'.get_permalink().'" style="background-color: rgba(225,225,225,.3);">
								<img src="'.ghost_get_option('post_lazy_img').'" data-original="'.catch_that_image().'" alt="'.get_the_title().'" class="lazy ghost-popular-img show" style="background-color: rgb(245, 217, 215); display: inline;">
								<div class="ghost-popular-mask"></div>
								<h3 class="ghost-popular-title">
									<span class="ghost-popular-text">'.get_the_title().'</span>
								</h3>
							</a>';
			endwhile;
			endif;
			// 重置文章数据
			wp_reset_postdata();
		}elseif($type=='headbox'){
			//第一次进入,需要缓存
			$args = array(
				'cat' => $cat_id,
				'order' => 'DESC',
				'posts_per_page' => 12,
				'paged' => 1,
				// 用于查询的参数或者参数集合
			);
			$the_query = new WP_Query( $args );
			// 循环开始
			if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : $the_query->the_post();
			$user_id = get_post(get_the_ID())->post_author;
				$content.='<div class="col-md-2 box-1 float-left">
					<article id="post-'.get_the_ID().'" class="post type-post status-publish format-standard">
						<div class="entry-thumb hover-scale">
									<a href="'.get_permalink().'"><img width="500" height="340" src="'.ghost_get_option('post_lazy_img').'" data-original="'.catch_that_image().'" class="lazy show" alt="'.get_the_title().'" style="display: block;">'.get_video_post_icon(get_the_ID()).'</a>
									<ul class="post-categories">
									<li><a href="'.get_permalink().'" rel="category tag">'.get_the_category()[0]->cat_name.'</a></li></ul>
									</div>
									<a href="'.ghost_get_user_author_link($user_id).'" target="_blank" class="post_box_avatar_link" title="'.get_user_meta($user_id,'nickname',true).'">
										<img class="post_box_avatar_img" title="'.get_user_meta($user_id,'nickname',true).'" src="'.get_user_meta($user_id,'ghost_user_avatar',true).'" width="50" height="50" alt="'.get_user_meta($user_id,'nickname',true).'">
										<span class="post_box_avatar_author_name">'.get_user_meta($user_id,'nickname',true).'</span>
									</a>
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
			endif;
			// 重置文章数据
			wp_reset_postdata();
		}elseif($type=='headbox2'){
			//第一次进入,需要缓存
			$args = array(
				'cat' => $cat_id,
				'order' => 'DESC',
				'posts_per_page' => 12,
				'paged' => 1,
				// 用于查询的参数或者参数集合
			);
			$the_query = new WP_Query( $args );
			// 循环开始
			if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : $the_query->the_post();
			$user_id = get_post(get_the_ID())->post_author;
				$content.='<div class="col-md-2 box-2 float-left">
					<article id="post-'.get_the_ID().'" class="post type-post status-publish format-standard">
						<div class="entry-thumb hover-scale">
									<a href="'.get_permalink().'"><img width="500" height="340" src="'.ghost_get_option('post_lazy_img').'" data-original="'.catch_that_image().'" class="lazy show" alt="'.get_the_title().'" style="display: block;"></a>
									<ul class="post-categories">
									<li><a href="'.get_permalink().'" rel="category tag">'.get_the_category()[0]->cat_name.'</a></li></ul>
									</div>
									<a href="'.ghost_get_user_author_link($user_id).'" target="_blank" class="post_box_avatar_link" title="'.get_user_meta($user_id,'nickname',true).'">
										<img class="post_box_avatar_img" title="'.get_user_meta($user_id,'nickname',true).'" src="'.get_user_meta($user_id,'ghost_user_avatar',true).'" width="50" height="50" alt="'.get_user_meta($user_id,'nickname',true).'">
										<span class="post_box_avatar_author_name">'.get_user_meta($user_id,'nickname',true).'</span>
									</a>
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
			endif;
			// 重置文章数据
			wp_reset_postdata();
		}elseif($type=='headbox3'){
			//第一次进入,需要缓存
			$args = array(
				'cat' => $cat_id,
				'order' => 'DESC',
				'posts_per_page' => 6,
				'paged' => 1,
				// 用于查询的参数或者参数集合
			);
			$the_query = new WP_Query( $args );
			// 循环开始
			if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : $the_query->the_post();
			$user_id = get_post(get_the_ID())->post_author;
				$content.='<div class="col-md-2 box-1 float-left">
					<article id="post-'.get_the_ID().'" class="post type-post status-publish format-standard">
						<div class="entry-thumb hover-scale">
									<a href="'.get_permalink().'"><img width="500" height="340" src="'.ghost_get_option('post_lazy_img').'" data-original="'.catch_that_image().'" class="lazy show" alt="'.get_the_title().'" style="display: block;">'.get_video_post_icon(get_the_ID()).'</a>
									<ul class="post-categories">
									<li><a href="'.get_permalink().'" rel="category tag">'.get_the_category()[0]->cat_name.'</a></li></ul>
									</div>
									<a href="'.ghost_get_user_author_link($user_id).'" target="_blank" class="post_box_avatar_link" title="'.get_user_meta($user_id,'nickname',true).'">
										<img class="post_box_avatar_img" title="'.get_user_meta($user_id,'nickname',true).'" src="'.get_user_meta($user_id,'ghost_user_avatar',true).'" width="50" height="50" alt="'.get_user_meta($user_id,'nickname',true).'">
										<span class="post_box_avatar_author_name">'.get_user_meta($user_id,'nickname',true).'</span>
									</a>
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
			endif;
			// 重置文章数据
			wp_reset_postdata();
		}elseif($type=='cat'){
			//第一次进入,需要缓存
			$args = array(
				'cat' => $cat_id,
				'order' => 'DESC',
				'posts_per_page' => 24,
				'paged' => $paged,
				// 用于查询的参数或者参数集合
			);
			$the_query = new WP_Query( $args );
			// 循环开始
			if ( $the_query->have_posts() ) :
			$content.= '<div class="single_posts">';
			while ( $the_query->have_posts() ) : $the_query->the_post();
			$user_id = get_post(get_the_ID())->post_author;
				$content.='<div class="col-md-2 box-1 float-left">
					<article id="post-'.get_the_ID().'" class="post type-post status-publish format-standard">
						<div class="entry-thumb hover-scale">
									<a href="'.get_permalink().'"><img width="500" height="340" src="'.ghost_get_option('post_lazy_img').'" data-original="'.catch_that_image().'" class="lazy show" alt="'.get_the_title().'" style="display: block;">'.get_video_post_icon(get_the_ID()).'</a>
									<ul class="post-categories">
									<li><a href="'.get_permalink().'" rel="category tag">'.get_the_category()[0]->cat_name.'</a></li></ul>
									</div>
									<a href="'.ghost_get_user_author_link($user_id).'" target="_blank" class="post_box_avatar_link" title="'.get_user_meta($user_id,'nickname',true).'">
										<img class="post_box_avatar_img" title="'.get_user_meta($user_id,'nickname',true).'" src="'.get_user_meta($user_id,'ghost_user_avatar',true).'" width="50" height="50" alt="'.get_user_meta($user_id,'nickname',true).'">
										<span class="post_box_avatar_author_name">'.get_user_meta($user_id,'nickname',true).'</span>
									</a>
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
			$content.= '<div class="ghost_other_more_post">
						<a data-paged="'.get_query_var('paged').'" data-cat="'.get_query_var('cat').'" class="more-post ajax-morepost">更多文章 <i class="tico tico-angle-right"></i></a>
					</div></div>';
			else:
				require(get_template_directory().'/mod/error.php');
			endif;
			// 重置文章数据
			wp_reset_postdata();
		}
	}
    return $content;
}
