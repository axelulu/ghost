<?php
require( '../../../../../wp-load.php' );
$user_id =  $_POST['uid'];
$user_data = get_userdata($user_id);
?>
<div class="ghost_author_comment_container">
    
    <?php
    $args = array(
		'user_id' => $user_id, // use user_id
	);
	$comments = get_comments($args);
	if(!empty($comments)){
    	foreach($comments as $comment) : ?>
            <section class="ghost_author_comment_item">
                <div class="ghost_author_comment_item_content">
                    <h3 class="ghost_author_comment_item_title">
                        <a href="<?php echo get_permalink($comment->comment_post_ID) ?>" class="ghost_author_comment_item_link"><?php echo get_post($comment->comment_post_ID)->post_title ?></a></h3>
                    <div class="ghost_author_comment_item_text"><?php echo $comment->comment_content ?></div>
                </div>
                <time title="2019-12-28 03:05:05" datetime="2019-12-28 03:05:05" class="ghost_author_comment_item_date"><?php echo $comment->comment_date ?></time>
            </section>
        <?php endforeach;
	}else{
        require(get_template_directory().'/mod/error.php');
	}
    ?>
</div>