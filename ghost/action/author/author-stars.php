<?php 
require( '../../../../../wp-load.php' );
$user_id =  $_POST['uid'];
$user_data = get_userdata($user_id);
?>
<section class="cat-2 cat-col cat-col-full">
    <div class="cat-container clearfix">
            <div id="ghost_box_1" class="cms-cat cms-cat-s7">
            <?php 
                $page = isset($_POST['page']) ? $_POST['page'] : 1 ;
                $args = array(
                    'order' => 'DESC',
                    // 用于查询的参数或者参数集合
                );
                $the_query = new WP_Query( $args );
                // 循环开始
                if ( $the_query->have_posts() ) :?>
                <div class="page-<?php echo $page ?>">
                    <?php while ( $the_query->have_posts() ) : $the_query->the_post();
									$shoucangmeta1 = explode(',',get_post_meta(get_the_ID(),'post_stars',true));
									$shoucangmeta = array_filter($shoucangmeta1);
									if(in_array($user_id,$shoucangmeta)){ ?>
                        <div class="col-md-2 box-1 float-left">
                            <article class="post type-post status-publish format-standard">
                                <div class="entry-thumb hover-scale">
                                    <a href="<?php the_permalink();?>"><img width="500" height="340" src="<?php echo ghost_get_option('post_lazy_img');?>" data-original="<?php echo catch_that_image();?>" class="lazy show" alt="<?php the_title();?>" style="display: block;"></a>
                                    <?php the_category() ?>
                                </div>
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
                    <?php } endwhile;?>
<!--                         <div class="ghost_other_more_post">
                            <a data-paged="<?php echo get_query_var('paged') ?>" data-cat="<?php echo get_query_var('cat') ?>" class="more-post ajax-morepost">更多文章 <i class="tico tico-angle-right"></i></a>
                        </div> -->
                    </div>
                    <?php else:
                        require(get_template_directory().'/mod/error.php');
                    endif;
                    // 重置文章数据
                    wp_reset_postdata();
                    ?>
                </div>                            
            </div>
    </section>