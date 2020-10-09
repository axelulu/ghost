<?php 
require( '../../../../wp-load.php' );
$paixu = isset($_POST['paixu']) ? $_POST['paixu'] : 'new';
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
// WP_User_Query参数
if($paixu=='new'){
	$authors = new WP_User_Query( array ( 
		'meta_key' => 'sign_daily',
		'meta_value' =>$beginToday,
		'meta_compare'=>'>=',
		'order'	 => 'DESC ',
	));
	$authors = $authors->get_results();
}elseif($paixu=='num'){
    $args = array (
        'meta_key' => 'sign_daily_num',
        'orderby' => 'meta_value_num',
        'order'	 => 'DESC',
        'number'=> ghost_get_option('page_postrank_num'),
    );
$authors = get_users($args);
}elseif($paixu=='credit'){
    $args = array (
        'meta_key' => 'user_credit',
        'orderby' => 'meta_value_num',
        'order'	 => 'DESC',
        'number'=> ghost_get_option('page_postrank_num'),
    );
$authors = get_users($args);
}

$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
if(!empty($authors)){
    foreach($authors as $author ){
        $times = !empty(get_user_meta($author->ID,'sign_daily',true)) ? ghost_date(date("Y-m-d H:i:s",get_user_meta($author->ID,'sign_daily',true))) : 0;
        $days = !empty(get_user_meta($author->ID,'sign_daily_num',true)) ? get_user_meta($author->ID,'sign_daily_num',true) : 0;
        $credit = !empty(get_user_meta($author->ID,'user_credit',true)) ? get_user_meta($author->ID,'user_credit',true) : 0;
        if($paixu=='new'){
            if( get_user_meta($author->ID,'sign_daily',true) > $beginToday && get_user_meta($author->ID,'sign_daily',true) < $endToday ){?>
                <div class="ghost_user_item float-left">
                    <a class="ghost_user_item_link" href="<?php echo ghost_get_user_author_link($author->ID); ?>">
                        <img title="<?php echo get_user_meta($author->ID,'nickname',true) ?>" alt="<?php echo get_user_meta($author->ID,'nickname',true) ?>" class="ghost_user_item_avatar_img" src="<?php echo get_user_meta($author->ID,'ghost_user_avatar',true) ?>" width="100" height="100"></a>
                    <a class="ghost_user_item_author_link" href="<?php echo ghost_get_user_author_link($author->ID); ?>" target="_self" title="<?php echo get_user_meta($author->ID,'nickname',true) ?>">
                        <span class="ghost_user_item_author_name"><?php echo get_user_meta($author->ID,'nickname',true) ?></span></a>
                                    <div class="ghost_user_item_author_credit">签到时间：<?php echo $times; ?></div>
                                    <div style="top: 33px;" class="ghost_user_item_author_credit">连续签到：<?php echo $days; ?>天</div>
														<div style="top: 47px;" class="ghost_user_item_author_credit">积分：<?php echo $credit; ?></div>
                </div>
            <?php }
        }else{?>
            <div class="ghost_user_item float-left">
                    <a class="ghost_user_item_link" href="<?php echo ghost_get_user_author_link($author->ID); ?>">
                        <img title="<?php echo get_user_meta($author->ID,'nickname',true) ?>" alt="<?php echo get_user_meta($author->ID,'nickname',true) ?>" class="ghost_user_item_avatar_img" src="<?php echo get_user_meta($author->ID,'ghost_user_avatar',true) ?>" width="100" height="100"></a>
                    <a class="ghost_user_item_author_link" href="<?php echo ghost_get_user_author_link($author->ID); ?>" target="_self" title="<?php echo get_user_meta($author->ID,'nickname',true) ?>">
                        <span class="ghost_user_item_author_name"><?php echo get_user_meta($author->ID,'nickname',true) ?></span></a>
                                    <div class="ghost_user_item_author_credit">签到时间：<?php echo $times; ?></div>
                                    <div style="top: 33px;" class="ghost_user_item_author_credit">连续签到：<?php echo $days; ?>天</div>
                                    <div style="top: 47px;" class="ghost_user_item_author_credit">积分：<?php echo $credit; ?></div>
                </div>
        <?php }
    }?>
<?php }else{
    header( 'content-type: application/json; charset=utf-8' );
    $result['status']	= 0;
    echo json_encode( $result );
    exit;
} ?>