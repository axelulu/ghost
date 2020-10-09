<?php
require( '../../../../../wp-load.php' );
global $current_user;
$user_id = $_POST['uid'];
$user_data = get_userdata($user_id);
$description = $user_data->description ? $user_data->description : '这个人太懒，什么都没写~~';
$ip_ = '';
$data_ = '';
foreach (get_user_meta( $user_id, 'session_tokens', true ) as $index => $value) {
$ip_ = $value['ip'];
$data_ = date("Y-m-d H:i:s",$value['login']);
}
$ip = new visitorInfo();
$meta = $ip->findCityByIp($html);
?>
<fieldset class="ghost_author_portal">
    <legend class="ghost_author_portal_legend">
        <span class="ghost_author_portal_label_info">基本资料</span></legend>
    <div class="ghost_author_portal_item_container">
        <div class="ghost_author_portal_portal_item">
            <div class="ghost_author_portal_item_title">昵称</div>
            <div class="ghost_author_portal_item_content"><?php echo $user_data->nickname ?></div></div>
        <div class="ghost_author_portal_portal_item">
            <div class="ghost_author_portal_item_title">UID</div>
            <div class="ghost_author_portal_item_content"><?php echo $user_id ?></div></div>
        <div class="ghost_author_portal_portal_item">
            <div class="ghost_author_portal_item_title">描述</div>
            <div class="ghost_author_portal_item_content"><?php echo $description ?></div>
        </div>
        <div class="ghost_author_portal_portal_item">
            <div class="ghost_author_portal_item_title">累计喵爪</div>
            <div class="ghost_author_portal_item_content"><?php echo get_user_meta($user_id,'user_credit',true) ?></div></div>
        <div class="ghost_author_portal_portal_item">
            <div class="ghost_author_portal_item_title">累计发帖</div>
            <div class="ghost_author_portal_item_content"><?php echo wp_count_posts()->publish; ?></div></div>
        <div class="ghost_author_portal_portal_item">
            <div class="ghost_author_portal_item_title">累计评论</div>
            <div class="ghost_author_portal_item_content"><?php echo get_comments('count=true&user_id='.$user_data->ID); ?></div>
        </div>
			<?php if(current_user_can('level_10') || get_user_meta($user_id,'show_ip',true)=='yes' || $user_id==$current_user->ID){ ?>
        <div class="ghost_author_portal_portal_item">
					<div class="ghost_author_portal_item_title">在线ip</div>
            <div class="ghost_author_portal_item_content"><?php echo $ip_; ?></div>
        </div>
        <div class="ghost_author_portal_portal_item">
					<div class="ghost_author_portal_item_title">在线时间</div>
            <div class="ghost_author_portal_item_content"><?php echo $data_; ?></div>
        </div>
        <div class="ghost_author_portal_portal_item">
					<div class="ghost_author_portal_item_title">所在省</div>
            <div class="ghost_author_portal_item_content"><?php echo $meta['result']['ad_info']['province']; ?></div>
        </div>
        <div class="ghost_author_portal_portal_item">
					<div class="ghost_author_portal_item_title">所在城市</div>
            <div class="ghost_author_portal_item_content"><?php echo $meta['result']['ad_info']['city']; ?></div>
        </div>
			<?php } ?>
    </div>
</fieldset>