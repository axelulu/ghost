<?php 
 
 class ghost_hot_post extends WP_Widget {
  
     function __construct()
     {
         $widget_ops = array('description' => '热门文章');
         parent::__construct(false,$name='热门文章',$widget_ops);  
     }
  
     function form($instance) { // 给小工具(widget) 添加表单内容
        $title = esc_attr($instance['title']);
        $post_type = esc_attr($instance['post_type']);
        $num = esc_attr($instance['num']);
     ?>
     <p><label for="<?php echo $this->get_field_id('title'); ?>">
            标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            显示数量：<input class="widefat" id="<?php echo $this->get_field_id('num'); ?>" name="<?php echo $this->get_field_name('num'); ?>" type="text" value="<?php echo $num; ?>" />
            <p>
                <label>文章排序</label>
                <select name="<?php echo $this->get_field_name( 'post_type' ); ?>" id="<?php echo $this->get_field_id('post_type'); ?>">
                    <option value="comment_count" <?php echo ($post_type == "comment_count" ? 'selected="selected"' : ''); ?>>评论优先</option>
                    <option value="date" <?php echo ($post_type == "date" ? 'selected="selected"' : ''); ?>>最新优先</option>
                    <option value="rand" <?php echo ($post_type == "rand" ? 'selected="selected"' : ''); ?>>随机文章</option>
                </select>
            </p>
        </label>
    </p>
     <?php
     }
     function update($new_instance, $old_instance) { // 更新保存
         return $new_instance;
     }
     function widget($args, $instance) { // 输出显示在页面上
     extract( $args );
         $title = apply_filters('widget_title', empty($instance['title']) ? __('小测试') : $instance['title']);
		 	
//实例化redis
$redis = new \Redis();
//连接redis
$redis->connect('127.0.0.1',6379);
if($redis->get('inner_widget_hotpost')=='yes' || !$redis->get('inner_widget_hotpost')){
		$widget_hotpost='';
		$args = array(
			'order' => 'DESC',
			'orderby' => $instance['post_type'],
			'posts_per_page' => $instance['num'],
			'paged' => 1,
			// 用于查询的参数或者参数集合
		);
		$the_query = new WP_Query( $args );
		// 循环开始
		if ( $the_query->have_posts() ) :
		while ( $the_query->have_posts() ) : $the_query->the_post();
		$widget_hotpost .= '<article id="post-1506" class="ghost_hot_post_article">
			<div class="ghost_hot_post_post">
				<div class="ghost_hot_post_item_container">
					<a href="'.get_permalink().'" class="ghost_hot_post_item_container_a">
						<img class="ghost_hot_post_item_container_img" src="'.catch_that_image().'" data-original="'.catch_that_image().'" alt="'.get_the_title().'" width="320" height="180" style="display: block;"></a>
					<div class="ghost_hot_post_item_container_item_view">
						<i class="fa-eye fas fa-fw poi-icon"></i>'.get_post_views().'</div>
					<div class="ghost_hot_post_item_container_time">
						<time datetime="'.get_the_date().'" title="'.get_the_date().'">'.get_the_date().'</time></div>
				</div>
				<h3 class="ghost_hot_post_item_container_item__title" title="'.get_the_title().'">
					<a href="'.get_permalink().'" class="ghost_hot_post_item_container_title__link">'.get_the_title().'</a></h3>
			</div>
		</article>';
		endwhile;endif;
		// 重置文章数据
		wp_reset_postdata();
		//将数据存入redis的list中
		$menujson=json_encode($widget_hotpost);
		$redis->del('widget_hotpost');//把键值删除，防止重复
		$redis->lPush('widget_hotpost', $menujson);
		$hshs = $redis->set('inner_widget_hotpost', 'no',(int)ghost_get_option('redis_past_time')); //设置键值有效期为60秒
}else{
		//从redis中取出数据
		$widget_hotpost=$redis->lRange('widget_hotpost', 0, -1);
		$widget_hotpost=json_decode($widget_hotpost[0],true);
}
         ?>
                <?php echo $before_widget; ?>
                <div id="ghost_hot_post" class="ghost_hot_post">
                    <h3 class="ghost_hot_post_title">
                        <span>
                            <i class="fas fa-eye"></i>
                            <span><? echo $instance['title'] ?></span></span>
                    </h3>
                    <div class="ghost_hot_post_container clearfix">
                        <?php echo $widget_hotpost;?>
                    </div>
                </div>
               <?php echo $after_widget; ?>
  
         <?php
     }
 }
 register_widget('ghost_hot_post');
 ?>