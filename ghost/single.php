<?php
global $current_user;
get_header();
$user_id = get_post(get_the_ID())->post_author;
$post_id = get_the_ID();
$baidu_site = ghost_get_option('baidu_site');
$baidu_site_token = ghost_get_option('baidu_site_token');
$url = get_permalink($post_id);
$shoucang1 = explode(',',get_post_meta(get_the_ID(),'post_stars',true));
$shoucang = array_filter($shoucang1);
$user = get_current_user_id();
//已成功推送的文章不再推送
if( 1 ){
    $api = 'http://data.zz.baidu.com/urls?site='.$baidu_site.'&token='.$baidu_site_token;
    $ch = curl_init();
    $options = array(
        CURLOPT_URL => $api,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => $url,
        CURLOPT_HTTPHEADER => array('Content-Type:text/plain'),
    );
    curl_setopt_array($ch, $options);
    $result = json_decode(curl_exec($ch),true);
}
$video_urls=json_decode(get_post_meta($post_id,'ghost_video',true));
$music_urls=json_decode(get_post_meta($post_id,'ghost_music',true));
$deflink = empty(ghost_get_option('ghost_site_me_link')) ? 'me' : ghost_get_option('ghost_site_me_link');

$single_box = get_redis('single_box'.ghost_get_post_cat_id(get_the_ID()),'single_post');
$post_content_ = do_shortcode(convert_smilies(wpautop(get_post(get_the_ID())->post_content)));

// 分享
$site_name = esc_attr(get_bloginfo( 'name' ));
$post_title = esc_attr(get_the_title());
$post_content = esc_attr(get_the_title());
$thumb = esc_url(get_the_post_thumbnail_url());
$qq = 'http://connect.qq.com/widget/shareqq/index.html?url='.esc_url(get_the_permalink()).'&desc=来<'.$site_name.'>看看这篇文章吧，有惊喜哦！&title='.$post_title.'&summary='.$post_content.'&pics='.$thumb.'&site='.$site_name;
$weibo = 'http://service.weibo.com/share/share.php?url='.esc_url(get_the_permalink()).'&coun=1&pic='.$thumb.'&title='.$post_title;
$weixin = '';
$tieba = 'http://tieba.baidu.com/f/commit/share/openShareApi?url='.esc_url(get_the_permalink()).'&title='.$post_title.'&comment=&pic='.$thumb.'&red_tag=y2016799123';
?>
<?php if($video_urls){?>
    <div data-id="<?php echo $post_id; ?>" class="post_video_mod">
    <div class="container clearfix">
        <div id="post_video" class="post-style-5-video-box">
            <?php if( is_user_logged_in() && (current_user_can( 'svip' ) || current_user_can( 'vip' ) || current_user_can( 'manage_options' ) )) {?>
						<iframe src="<?php echo get_bloginfo('url');?>/player/?url=<?php echo $video_urls[0]->link; ?>" class="iframe ghost_play" width="810" height="450"></iframe>
            <?php }elseif(!is_user_logged_in()){ ?>
                <div class="post_video_login">
                    <div class="ghost_download_content_btn" style="width:100px">
                        <div class="poi-btn-group">
                            <a class="ghost_btn ghost_btn_success download user-login" rel="noreferrer" target="_blank">
                                <span class="poi-icon fa-cloud-download-alt fas fa-fw" aria-hidden="true"></span>
                                <span class="ghost_icon_text">登陆</span></a>
                        </div>
                    </div>
                </div>
            <?php }else{ ?>
                <div class="post_video_login">
                    <div class="ghost_download_content_btn" style="width:100px">
                        <div class="poi-btn-group">
                            <a href="<?php echo home_url('/'.$deflink.'/answer'); ?>" href="<?php echo home_url('/'.$deflink.'/answer'); ?>" class="ghost_btn ghost_btn_success download" rel="noreferrer" target="_blank">
                                <span class="poi-icon fa-cloud-download-alt fas fa-fw" aria-hidden="true"></span>
                                <span class="ghost_icon_text">答题</span></a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="post-video-list">
            <ul class="video_post_right">
                <?php 
                foreach($video_urls as $video_url){ ?>
                    <li class="switch_set" data-url="<?php echo $video_url->link ?>">
                        <div>
                            <div class="post-video-list-img">
                                <img src="<?php echo $video_url->link.'?x-oss-process=video/snapshot,t_7000,f_jpg,w_100,h_60,m_fast' ?>"></div>
                            <div class="video-list-title">
                                <span><?php echo $video_url->name ?></span></div>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>    
<?php } ?>
<div class="main single container">
    <div class="clearfix">
        <div data-id="<?php echo get_the_ID() ?>" class="article float-left col-lg-9">
            <article>
                <h1 class="ghost_single_title"><?php echo get_post(get_the_ID())->post_title ?></h1>
                <header class="ghost_single_header"> 
                    <span class="single_header_item ghost_single_category" title="分类"> 
								<a href="<?php echo get_category_link(ghost_get_post_cat_id(get_the_ID())) ?>" rel="category tag">
                        <i class="fa-folder-open fas fa-fw poi-icon" aria-hidden="true"></i> 
                        <span class="ghost_icon_text"><?php echo get_cat_name(ghost_get_post_cat_id(get_the_ID())) ?>
                        </span>
								</a>
                    </span> 
                    <time datetime="<?php echo get_post(get_the_ID())->post_date ?>" class="single_header_item ghost_single_date" title="<?php echo get_post(get_the_ID())->post_date ?>"> 
                        <i class="fa-clock fas fa-fw poi-icon" aria-hidden="true"></i> 
                        <span class="ghost_icon_text"><?php echo ghost_date(get_post(get_the_ID())->post_date) ?></span>
                    </time> 
                    <a href="<?php echo ghost_get_user_author_link($user_id); ?>" title="<?php echo get_user_meta($user_id,'nickname',true) ?>" class="single_header_item ghost_single_author"> 
                        <i class="fa-user-circle fas fa-fw poi-icon" aria-hidden="true"></i> <span class="ghost_icon_text"><?php echo get_user_meta($user_id,'nickname',true) ?></span>
                    </a> 
                    <span class="single_header_item ghost_single_view" title="查看数"> 
								<a href="javascript:void(0)">
									<i class="fa-play-circle fas fa-fw poi-icon" aria-hidden="true"></i> 
                        <span class="ghost_single_view_num"><?php echo get_post_views(); ?></span>
									</a>
                    </span> 
                    <span class="single_header_item ghost_single_comment_count" title="评论数">
								<a href="javascript:void(0)">
                        <i class="fa-comments fas fa-fw poi-icon" aria-hidden="true"></i> 
                        <span class="ghost_single_comment_count_num"><?php echo get_post(get_the_ID())->comment_count ?></span>
									</a>
                    </span> 
                    <span class="single_header_item ghost_single_sell_count" title="文章出售数量">
								<a href="javascript:void(0)">
                        <i class="fas fa-shopping-cart fa-fw poi-icon" aria-hidden="true"></i> 
                        <span class="ghost_single_sell_count_num"><?php echo ghost_get_post_shop_num(get_the_ID()) ?></span>
									</a>
                    </span> 
                    <?php if($user_id==$current_user->ID || current_user_can('level_10')): ?>
                    <span class="single_header_item " title="编辑文章"> 
                        <a href="<?php echo home_url('/'.$deflink.'/edit_post?post_id='.get_the_ID()); ?>" target="_blank"><i class="poi-icon fas fa-paint-brush fa-fw" aria-hidden="true"></i> 
                            <span class="">编辑文章</span></a>
                    </span>
							<?php endif;?>
							<?php if(current_user_can('level_10')){ ?>
							<span class="single_header_item delete_my_post" title="删除文章"> 
								<a href="javascript:void(0)">
                        <i class="fa-comments fas fa-fw poi-icon" aria-hidden="true"></i> 
                        <span class="">删除文章</span>
									</a>
                    </span>
								<?php } ?>
                    <span class="single_header_item " title="百度收录"> 
                        <i class="fa-comments fas fa-fw poi-icon" aria-hidden="true"></i> 
                        <span class=""><?php echo baidu_record($url) ?></span>
                    </span>
                </header>
                <div class="single_post_body">
                <!--音乐-->
                <?if($music_urls){?>
                        <div id="post_music" class="post-style-5-video-box">
                            <script>
                            jQuery(function ($) {
                                var music_one = "<?php echo $music_urls[0]->link; ?>";
                                var cover_one = "<?php echo $music_urls[0]->link; ?>";
                                var name_one = "<?php echo $music_urls[0]->name; ?>";
                                $.APlayer_(music_one,cover_one,name_one);
                            })
                            </script>
                        </div>
                <?php } ?>
                    <div class="content"><?php echo $post_content_; ?></div>
                </div>
                <div class="ghost_download_content">
					<div>文章作者的链接:</div>
                    <?php 
                        $download = get_post_meta(get_the_ID(),'ghost_download',true);
                        $adddownload = get_post_meta(get_the_ID(),'ghost_download_addlink',true);
                        $user_metass = json_decode(get_user_meta($current_user->ID,get_the_ID(),true));
                        if(isset($download)):
                        if( is_user_logged_in() && (current_user_can( 'svip' ) || current_user_can( 'vip' ) || current_user_can( 'manage_options' ) )) {
                        foreach($download as $key => $downloads){
								if($user_metass[$key]->type || $downloads['credit']==0 || !isset($downloads['credit']) || current_user_can( 'manage_options' )){
                    ?>
                    <fieldset class="ghost_download_content_content">
                        <legend class="ghost_download_content_name">
                            <span class="ghost_download_label_success"><?php echo $downloads['name']; ?></span></legend>
                        <div class="ghost_download_content_item_download_pwd">
                            <div class="ghost_download_">
                                <div class="col-lg-2 float-left">
                                    <div class="ghost_download_content_item_label">
                                        <span class="poi-icon fa-unlock-alt fas fa-fw" aria-hidden="true"></span>
                                        <span class="ghost_icon_text">提取密码</span></div>
                                </div>
                                <div style="padding-right:0px" class="col-lg-10 float-left">
                                    <div class="poi-btn-group">
                                        <input class="ghost_input ghost_download_content_item_input" type="text" readonly="" value="<?php echo $downloads['pwd']; ?>">
                                        <a class="ghost_btn ghost_btn_success ghost_btn_copy">
                                            <span class="poi-icon fa-copy fas fa-fw" aria-hidden="true"></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ghost_download_content_item_extract_pwd">
                            <div class="ghost_download_">
                                <div class="col-lg-2 float-left">
                                    <div class="ghost_download_content_item_label">
                                        <span class="poi-icon fa-key fas fa-fw" aria-hidden="true"></span>
                                        <span class="ghost_icon_text">解压密码</span></div>
                                </div>
                                <div style="padding-right:0px" class="col-lg-10 float-left">
                                    <div class="poi-btn-group">
                                        <input class="ghost_input ghost_download_content_item_input" type="text" readonly="" value="<?php echo $downloads['pwd2']; ?>">
                                        <a class="ghost_btn ghost_btn_success ghost_btn_copy">
                                            <span class="poi-icon fa-copy fas fa-fw" aria-hidden="true"></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ghost_download_content_btn">
                            <div class="poi-btn-group">
                                <a href="<?php echo $downloads['link']; ?>" value="<?php echo $downloads['link']; ?>" class="ghost_btn ghost_btn_success download" rel="noreferrer" target="_blank">
                                    <span class="poi-icon fa-cloud-download-alt fas fa-fw" aria-hidden="true"></span>
                                    <span class="ghost_icon_text">下载（如果点击无反应，可能是磁力链接）</span></a>
                            </div>
                        </div>
                    </fieldset>
                    <?php 
								}else{?>
                    <fieldset class="ghost_download_content_content">
                        <legend class="ghost_download_content_name">
                            <span class="ghost_download_label_success"><?php echo $downloads['name']; ?></span></legend>
                        <div class="ghost_download_content_btn">
                            <div class="poi-btn-group">
                                <a class="ghost_btn ghost_btn_success download buy_download_link" data-id="<?php echo $key ?>" data-author_id="<?php echo $user_id ?>" data-postid="<?php echo get_the_ID() ?>" rel="noreferrer" target="_blank">
                                    <span class="poi-icon fa-cloud-download-alt fas fa-fw" aria-hidden="true"></span>
                                    <span class="ghost_icon_text"><?php echo $downloads['credit']; ?>积分购买</span></a>
                            </div>
                        </div>
                    </fieldset>
							<?php }
							}
                    }elseif(!is_user_logged_in()){?>
                        <div class="ghost_download_content_btn">
                            <div class="poi-btn-group">
                                <a class="ghost_btn ghost_btn_success download user-login" rel="noreferrer" target="_blank">
                                    <span class="poi-icon fa-cloud-download-alt fas fa-fw" aria-hidden="true"></span>
                                    <span class="ghost_icon_text">登陆查看下载链接</span></a>
                            </div>
                        </div>
                    <? }else{?>
                        <div class="ghost_download_content_btn">
                            <div class="poi-btn-group">
                                <a href="<?php echo home_url('/'.$deflink.'/answer'); ?>" class="ghost_btn ghost_btn_success download" rel="noreferrer" target="_blank">
                                    <span class="poi-icon fa-cloud-download-alt fas fa-fw" aria-hidden="true"></span>
                                    <span class="ghost_icon_text">答题成为正式会员即可查看下载链接</span></a>
                            </div>
                        </div>
                    <? }endif; ?>
					<div>热心网友的补链:</div>
								<?php
								if(isset($adddownload)):
								if( is_user_logged_in() ) {
								foreach($adddownload as $key => $downloads){?>
					<fieldset class="ghost_download_content_content">
								<legend class="ghost_download_content_name">
									<span class="ghost_download_label_success"><?php echo $downloads['name']; ?><a href="<?php echo ghost_get_user_author_link($downloads['userid']); ?>">-->链接提供者：<?php echo get_user_meta($downloads['userid'],'nickname',true) ?></a></span></legend>
								<div class="ghost_download_content_item_download_pwd">
									<div class="ghost_download_">
										<div class="col-lg-2 float-left">
											<div class="ghost_download_content_item_label">
												<span class="poi-icon fa-unlock-alt fas fa-fw" aria-hidden="true"></span>
												<span class="ghost_icon_text">提取密码</span></div>
										</div>
										<div style="padding-right:0px" class="col-lg-10 float-left">
											<div class="poi-btn-group">
												<input class="ghost_input ghost_download_content_item_input" type="text" readonly="" value="<?php echo $downloads['pwd']; ?>">
												<a class="ghost_btn ghost_btn_success ghost_btn_copy">
													<span class="poi-icon fa-copy fas fa-fw" aria-hidden="true"></span>
												</a>
											</div>
										</div>
									</div>
								</div>
								<div class="ghost_download_content_item_extract_pwd">
									<div class="ghost_download_">
										<div class="col-lg-2 float-left">
											<div class="ghost_download_content_item_label">
												<span class="poi-icon fa-key fas fa-fw" aria-hidden="true"></span>
												<span class="ghost_icon_text">解压密码</span></div>
										</div>
										<div style="padding-right:0px" class="col-lg-10 float-left">
											<div class="poi-btn-group">
												<input class="ghost_input ghost_download_content_item_input" type="text" readonly="" value="<?php echo $downloads['pwd2']; ?>">
												<a class="ghost_btn ghost_btn_success ghost_btn_copy">
													<span class="poi-icon fa-copy fas fa-fw" aria-hidden="true"></span>
												</a>
											</div>
										</div>
									</div>
								</div>
								<div class="ghost_download_content_btn">
									<div class="poi-btn-group">
										<a href="<?php echo $downloads['link']; ?>" value="<?php echo $downloads['link']; ?>" class="ghost_btn ghost_btn_success download" rel="noreferrer" target="_blank">
											<span class="poi-icon fa-cloud-download-alt fas fa-fw" aria-hidden="true"></span>
											<span class="ghost_icon_text">下载（如果点击无反应，可能是磁力链接）</span></a>
									</div>
								</div>
								</fieldset>
						<?php }}endif;?>
                </div>
                <footer class="single_post_footer"> 
                    <div class="single_post_footer_tags"> 
                        <?php the_tags( '', '', '<br />' ); ?>
                    </div>
                    <div class="single_post_footer_box">
								<div class="single_post_footer_share"> 
									<a href="<?php echo $weibo; ?>" class="inn-singular__post__share__item poi-tooltip poi-tooltip_top" rel="nofollow" title="分享到微博" aria-label="分享到微博"> 
										<i class="fa-weibo fab fa-fw poi-icon" aria-hidden="true"></i> 
									</a>
									<a href="<?php echo $qq; ?>" class="inn-singular__post__share__item poi-tooltip poi-tooltip_top" rel="nofollow" title="分享到QQ空间" aria-label="分享到QQ空间"> 
										<i class="fa-qq fab fa-fw poi-icon" aria-hidden="true"></i> 
									</a>
									<a href="<?php echo $weixin; ?>" class="inn-singular__post__share__item poi-tooltip poi-tooltip_top" rel="nofollow" title="分享到微信" aria-label="分享到微信"> 
										<i class="fa-weixin fab fa-fw poi-icon" aria-hidden="true"></i> 
									</a>
									<a href="<?php echo $tieba; ?>" class="inn-singular__post__share__item poi-tooltip poi-tooltip_top" rel="nofollow" title="分享到贴吧" aria-label="分享到贴吧"> 
										<i class="fa-bold fas fa-fw poi-icon" aria-hidden="true"></i> 
									</a>
								</div> 
								<div id="ghost-report" class="single_post_footer_report">
									<div class="<?php echo get_my_login_type('ghost_report'); ?> single_post_footer_container">
										<a class="single_post_footer_btn"><span class="poi-icon fa-paperclip fas fa-fw" aria-hidden="true"></span> <span class="ghost_icon_text">链接失效</span></a>
									</div>
								</div>
								<div id="ghost-add_link" class="single_post_footer_report">
									<div data-userid="<?php echo $current_user->ID; ?>" class="<?php echo get_my_login_type('ghost_add_link'); ?> single_post_footer_container">
										<a class="single_post_footer_btn"><span class="poi-icon fa-link fas fa-fw" aria-hidden="true"></span> <span class="ghost_icon_text">帮他补链</span></a>
									</div>
								</div>
								<div class="single_post_footer_report">
									<div class="<?php echo get_my_login_type('download_img'); ?> single_post_footer_container">
										<a class="single_post_footer_btn"><span class="poi-icon fa-images fas fa-fw" aria-hidden="true"></span> <span class="ghost_icon_text">图片下载</span></a>
									</div>
								</div>
								<div class="single_post_footer_report">
									<?php if(in_array($user,$shoucang)){ foreach($shoucang as $k=>$v){ if($v==$user){ ?>
									<div class="<?php echo get_my_login_type('post_stars'); ?> single_post_footer_container">
										<a class="single_post_footer_btn on"><span class="poi-icon fa-star fas fa-fw" aria-hidden="true"></span> <span class="ghost_icon_text">已收藏</span></a>
									</div>
									<?php }}}else{ ?>
									<div class="<?php echo get_my_login_type('post_stars'); ?> single_post_footer_container">
										<a class="single_post_footer_btn"><span class="poi-icon fa-star far fa-fw" aria-hidden="true"></span> <span class="ghost_icon_text">收藏文章</span></a>
									</div>
									<?php };?>
								</div>
                    </div>
                    <ul class="single_post_footer_source"> 
                    <li> 本作品是由 <a href="<?php echo get_bloginfo('url'); ?>"><?php echo get_bloginfo('name'); ?></a> 会员 <a href="<?php echo ghost_get_user_author_link($user_id); ?>"><?php echo get_user_meta($user_id,'nickname',true) ?></a> 的投递作品。 </li> <li>转载请务请署名并注明出处：<a href="<?php echo get_permalink() ?>" rel="nofollow"><?php echo get_permalink() ?></a>。</li>
                        <li>禁止再次修改后发布；任何商业用途均须联系作者。如未经授权用作他处，作者将保留追究侵权者法律责任的权利。</li>
                    </ul> 
                </footer>
            </article>
					<section>
						<div class="cat-container clearfix">
            <div id="ghost_box_1" class="cms-cat cms-cat-s7">
                <?php echo $single_box;?>
            </div>                            
        </div>
					</section>
            <aside>
                <?php 
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;
                ?>
            </aside>
        </div>
        <div class="weight float-right col-lg-3">
        <?php get_sidebar(); ?>
        </div>
    </div>
</div>
<script>
var FunLib = {
    // 图片打包下载
    download: function (images) {
        FunLib.packageImages(images)
    },
    // 打包压缩图片
    packageImages: function (imgs) {
        var imgBase64 = []
        var imageSuffix = [] // 图片后缀
        var zip = new JSZip()
        var img = zip.folder("images")
 
        for (var i = 0; i < imgs.length; i++) {
            var src = imgs[i].url
            var suffix = src.substring(src.lastIndexOf("."))
            imageSuffix.push(suffix)
            FunLib.getBase64(imgs[i].url).then(function (base64) {
                imgBase64.push(base64.substring(22))
                if (imgs.length === imgBase64.length) {
                    for (var i = 0; i < imgs.length; i++) {
                        img.file(imgs[i].name + imageSuffix[i], imgBase64[i], {base64: true})
                    }
                    zip.generateAsync({type: "blob"}).then(function (content) {
                        saveAs(content, "images.zip")
                    })
                }
            }, function (err) {
                console.log(err)
            })
        }
    },
    // 传入图片路径，返回base64
    getBase64: function (img) {
        var image = new Image()
        image.crossOrigin = 'Anonymous'
        image.src = img
        var deferred = $.Deferred()
        if (img) {
            image.onload = function () {
                var canvas = document.createElement("canvas")
                canvas.width = image.width
                canvas.height = image.height
                var ctx = canvas.getContext("2d")
                ctx.drawImage(image, 0, 0, canvas.width, canvas.height)
                var dataURL = canvas.toDataURL()
                deferred.resolve(dataURL)
            }
            return deferred.promise()
        }
    }
}

$('.single').on('click', '.download_img',
function(event) {
	$(this).removeClass('download_img');
	var imgs = new Array();
	var img = $('.content img');
	for(var i=0;i<img.length;i++){
			imgs[i] = new Object();
			imgs[i].url = img.get(i).src;
			imgs[i].name = i;
	}
	FunLib.download(imgs);
	$(this).html('<a class="single_post_footer_btn"><span class="poi-icon fa-flag fas fa-fw" aria-hidden="true"></span> <span class="ghost_icon_text">已请求，请等待</span></a>');
})
	//获取banner的高度
var bannerH=$(".widget_ghost_author").offset().top + $(".widget_ghost_author").height()-47;
//滚动事件
$(window).scroll(function(){
var nScrollTop = $(document).height() - $(document).scrollTop() - 1010 - 170;
var scrollTop=$(this).scrollTop();
//判断bannerH大于或者等于scrollTop高度
if(scrollTop >= bannerH ){
$(".widget_ghost_hot_post").addClass('widget_ghost_author_fixed');
$(".widget_ghost_hot_post").css('left',$(".weight").offset().left+7);
$(".widget_ghost_hot_post").css('top','56px');
}else{
$(".widget_ghost_hot_post").removeClass('widget_ghost_author_fixed');
$(".widget_ghost_hot_post").css('left','');
$(".widget_ghost_hot_post").css('top','');
}
if(nScrollTop <= 0 ){
$(".widget_ghost_hot_post").removeClass('widget_ghost_author_fixed');
$(".widget_ghost_hot_post").css('top','');
}else{
}
})
</script>
<?php get_footer();?>