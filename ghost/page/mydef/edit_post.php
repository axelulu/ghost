<?php
get_header();
if(is_user_logged_in()):
$post_id = $_GET['post_id'];
$musics = json_decode(get_post_meta($post_id,'ghost_music',true));
$videos = json_decode(get_post_meta($post_id,'ghost_video',true));

?>
<div class="main">
    <div class="clearfix container setting">
        <div class="col-lg-2 float-left">
            <?php require(get_template_directory().'/mod/sidebar.php');?>
        </div>
        <div class="col-lg-10 float-right setting_box">
            <div class="ghost_setting_content">
                <div class="drafts ghost_setting_content_container">
                    <fieldset class="ghost_setting_content_item">
                        <legend class="ghost_setting_content_item_title">
                            <span class="ghost_setting_content_primary">
                                <span class="poi-icon fa-user-circle fas fa-fw" aria-hidden="true"></span>
                                <span class="ghost_setting_content_text">投稿须知</span></span>
                        </legend>
                        <div class="ghost_setting_content_item_content">
                            <div class="ghost_setting_content_preface">
                                <p>您可以在这个页面查看您发布过的帖子，鼠标悬浮即可见编辑按钮。</p>
                                <p>重新编辑帖子后需要二次审核，请谨慎编辑哦！</p>
                            </div>
                            <div class="ghost_setting_content_my_avatar">
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="ghost_setting_content_item">
                        <legend class="ghost_setting_content_item_title">
                            <span class="ghost_setting_content_primary">
                                <span class="poi-icon fa-user-circle fas fa-fw" aria-hidden="true"></span>
                                <span class="ghost_setting_content_text">投稿类型</span></span>
                        </legend>
                        <div class="ghost_setting_content_item_content">
                            <div class="ghost_setting_content_preface_item_content">
                                <a class="ghost_setting_content_btn routine_post <?php if(!isset($musics)&&!isset($videos)){echo 'is_success';} ?>">
                                    <span class="poi-icon fa-check fas fa-fw" aria-hidden="true"></span>
                                    <span class="ghost_setting_content_text">常规</span></a>
                                <a class="ghost_setting_content_btn video_post <?php if(isset($videos)){echo 'is_success';} ?>">
                                    <span class="poi-icon fa-check fas fa-fw" aria-hidden="true"></span>
                                    <span class="ghost_setting_content_text">视频</span></a>
                                <a class="ghost_setting_content_btn music_post <?php if(isset($musics)){echo 'is_success';} ?>">
                                    <span class="poi-icon fa-check fas fa-fw" aria-hidden="true"></span>
                                    <span class="ghost_setting_content_text">音乐</span></a>
                            </div>
                        </div>
                    </fieldset>
                    <div class="extra_post_content">
                    <?php 
                        if(isset($videos)): 
                        $j=0;?>
                        <fieldset class="ghost_setting_content_item">
                            <legend class="ghost_setting_content_item_title">
                                <span class="ghost_setting_content_primary">
                                    <span class="poi-icon fa-user-circle fas fa-fw" aria-hidden="true"></span>
                                    <span class="ghost_setting_content_text">添加视频</span></span>
                            </legend>
                            <div class="ghost_setting_content_item_content ghost_video">
                            <?php 
                            foreach ($videos as $video ) { ?>
                                <div class="clearfix ghost_video_link">
                                    <div class="col-lg-4 float-left poi-g_lg-2-10">
                                        <label class="ghost_video_link_group_inputs">
                                            <span class="ghost_video_link_inputs_icon">
                                                <span class="poi-icon fa-cloud-download-alt fas fa-fw" aria-hidden="true"></span>
                                            </span>
                                            <span class="ghost_video_link_inputs_content">
                                                <input name="post_video_container[<?php echo $j; ?>][name]" class="ghost_setting_content_preface_control_videolink " type="text" placeholder="视频名称" title="视频名称" list="customPostStoragedatalist" value="<?php echo $video->name ?>"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-7 float-left poi-g_lg-2-10">
                                        <label class="ghost_video_link_group_inputs">
                                            <span class="ghost_video_link_inputs_icon">
                                                <span class="poi-icon fa-link fas fa-fw" aria-hidden="true"></span>
                                            </span>
                                            <span class="ghost_video_link_inputs_content">
                                                <input name="post_video_container[<?php echo $j++; ?>][link]" class="ghost_setting_content_preface_control_videolink " type="text" placeholder="视频地址" title="视频地址" list="customPostStoragedatalist" value="<?php echo $video->link ?>"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-1 float-left poi-g_lg-1-10">
                                        <div class="poi-btn-group ghost_video_link_storage_btns">
                                            <a class="video_add ghost_video_link_delete_btn">
                                                <span class="poi-icon fa-plus fas fa-fw" aria-hidden="true"></span>
                                            </a>
                                            <a class="ghost_video_link_delete_btn video_del" disabled="">
                                                <span class="poi-icon fa-trash fas fa-fw" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            </div>
                        </fieldset>
                        <?php endif; ?>
                        <?php 
                        if(isset($musics)): 
                        $k=0;?>
                        <fieldset class="ghost_setting_content_item">
                            <legend class="ghost_setting_content_item_title">
                                <span class="ghost_setting_content_primary">
                                    <span class="poi-icon fa-user-circle fas fa-fw" aria-hidden="true"></span>
                                    <span class="ghost_setting_content_text">添加音乐</span></span>
                            </legend>
                            <div class="ghost_setting_content_item_content ghost_music">
                            <?php 
                            foreach ($musics as $music ) { ?>
                                <div class="clearfix ghost_music_link">
                                    <div class="col-lg-4 float-left poi-g_lg-2-10">
                                        <label class="ghost_music_link_group_inputs">
                                            <span class="ghost_music_link_inputs_icon">
                                                <span class="poi-icon fa-cloud-download-alt fas fa-fw" aria-hidden="true"></span>
                                            </span>
                                            <span class="ghost_music_link_inputs_content">
                                                <input name="post_music_container[<?php echo $k; ?>][name]" class="ghost_setting_content_preface_control_musiclink " type="text" placeholder="视频名称" title="视频名称" list="customPostStoragedatalist" value="<?php echo $music->name ?>"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-7 float-left poi-g_lg-2-10">
                                        <label class="ghost_music_link_group_inputs">
                                            <span class="ghost_music_link_inputs_icon">
                                                <span class="poi-icon fa-link fas fa-fw" aria-hidden="true"></span>
                                            </span>
                                            <span class="ghost_music_link_inputs_content">
                                                <input name="post_music_container[<?php echo $k++; ?>][link]" class="ghost_setting_content_preface_control_musiclink " type="text" placeholder="视频地址" title="视频地址" list="customPostStoragedatalist" value="<?php echo $music->link ?>"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-1 float-left poi-g_lg-1-10">
                                        <div class="poi-btn-group ghost_music_link_storage_btns">
                                            <a class="music_add ghost_music_link_delete_btn">
                                                <span class="poi-icon fa-plus fas fa-fw" aria-hidden="true"></span>
                                            </a>
                                            <a class="ghost_music_link_delete_btn music_del" disabled="">
                                                <span class="poi-icon fa-trash fas fa-fw" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            </div>
                        </fieldset>
                        <?php endif; ?>
                    </div>
                    <fieldset class="ghost_setting_content_item">
                        <legend class="ghost_setting_content_item_title">
                            <span class="ghost_setting_content_primary">
                                <span class="poi-icon fa-user-circle fas fa-fw" aria-hidden="true"></span>
                                <span class="ghost_setting_content_text">帖子标题</span></span>
                        </legend>
                        <div class="ghost_setting_content_item_content">
                            <div class="ghost_setting_content_preface_item_content">
                                <input name="name" class="post_title ghost_setting_content_preface_control" required="" placeholder="帖子标题" title="帖子标题" value="<?php echo get_post($post_id)->post_title ?>"></div>
                        </div>
                    </fieldset>
                    <fieldset class="ghost_setting_content_item">
                        <legend class="ghost_setting_content_item_title">
                            <span class="ghost_setting_content_primary">
                                <span class="poi-icon fa-user-circle fas fa-fw" aria-hidden="true"></span>
                                <span class="ghost_setting_content_text">帖子内容</span></span>
                        </legend>
                        <div class="ghost_setting_content_item_content">
                        
              <textarea id="tinymce" name="meta"><?php echo do_shortcode(convert_smilies(wpautop(get_post($post_id)->post_content))) ?></textarea>
              <script>
                tinymce.init({
                    selector: '#tinymce',
                    //skin:'oxide-dark',
                    language:'zh_CN',
                    plugins: 'print preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media template code codesample table charmap hr pagebreak nonbreaking anchor insertdatetime advlist lists wordcount imagetools textpattern help emoticons autosave autoresize',
                    toolbar: 'code undo redo restoredraft | cut copy paste pastetext | forecolor backcolor bold italic underline strikethrough link anchor | alignleft aligncenter alignright alignjustify outdent indent | \
                    styleselect formatselect fontselect fontsizeselect | bullist numlist | blockquote subscript superscript removeformat | \
                    table image media charmap emoticons hr pagebreak insertdatetime print preview | fullscreen | bdmap indent2em lineheight formatpainter axupimgs',
                    height: 650, //编辑器高度
                    min_height: 400,
                    fontsize_formats: '12px 14px 16px 18px 24px 36px 48px 56px 72px',
                    font_formats: '微软雅黑=Microsoft YaHei,Helvetica Neue,PingFang SC,sans-serif;苹果苹方=PingFang SC,Microsoft YaHei,sans-serif;宋体=simsun,serif;仿宋体=FangSong,serif;黑体=SimHei,sans-serif;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;',
                    image_class_list: [
                    { title: 'None', value: '' },
                    { title: 'Some class', value: 'class-name' }
                    ],
                    importcss_append: true,
                    autosave_ask_before_unload: false,
                });
              </script>
                        </div>
                    </fieldset>
                    <fieldset class="ghost_setting_content_item">
                        <legend class="ghost_setting_content_item_title">
                            <span class="ghost_setting_content_primary">
                                <span class="poi-icon fa-user-circle fas fa-fw" aria-hidden="true"></span>
                                <span class="ghost_setting_content_text">帖子图片</span></span>
                        </legend>
                        <div class="ghost_setting_content_item_content">
                            <div class="ghost_post_imgs_upload">
                                <label class="ghost_post_imgs_upload_btn">
                                    <span class="poi-icon fa-hand-paper fas fa-fw" aria-hidden="true"></span> 
                                    <span class="poi-icon__text">添加图片</span>
                                    <input style="display:none" type="file" name="imgs_upload" id="imgs_upload" accept=".jpg, .gif, .png" multiple="">
                                </label>
                            </div>
                            <div class="ghost_mypic"></div>
                        </div>
                    </fieldset>
                    <fieldset class="ghost_setting_content_item">
                        <legend class="ghost_setting_content_item_title">
                            <span class="ghost_setting_content_primary">
                                <span class="poi-icon fa-user-circle fas fa-fw" aria-hidden="true"></span>
                                <span class="ghost_setting_content_text">帖子分类</span></span>
                        </legend>
                        <div class="ghost_setting_content_item_content">
                            <a style="font-size:12px" class="mypost_cat ghost_setting_content_preface_control">
                                <span class="poi-icon fa-sitemap fas fa-fw" aria-hidden="true"></span> 
                                <span class="mypost_cat_text"><?php echo get_cat_name(ghost_get_post_cat_id($post_id)) ?></span>
                            </a>
                            <input type="hidden" name="catId" value="<?php echo ghost_get_post_cat_id($post_id) ?>">
                        </div>
                    </fieldset>
                    <fieldset class="ghost_setting_content_item">
                        <legend class="ghost_setting_content_item_title">
                            <span class="ghost_setting_content_primary">
                                <span class="poi-icon fa-user-circle fas fa-fw" aria-hidden="true"></span>
                                <span class="ghost_setting_content_text">帖子标签</span></span>
                        </legend>
                        <div class="ghost_setting_content_item_content">
                            <div class="ghost_post_tag_inputs">
                                <?php 
                                $tags = wp_get_post_tags($post_id);
                                foreach ($tags as $tag ) {
                                ?>
                                <div class="poi-btn-group ghost_post_tag_inputs_container">
                                    <input type="text" class="ghost_setting_content_preface_control ghost_post_tag_input" name="tags[]" placeholder="帖子标签" value="<?php echo $tag->name ?>">
                                    <a class="poi-btn poi-btn_default ghost_post_tag_input_btn del_tag" disabled="">                            
                                        <span class="poi-icon fa-trash fas fa-fw" aria-hidden="true"></span>                        
                                    </a>
                                </div>
                                <?php } ?>
                            </div>
                            <a class="add_posttag ghost_setting_content_btn_success">
                                <span class="poi-icon fa-plus fas fa-fw" aria-hidden="true"></span>
                            </a>
                        </div>
                    </fieldset>
                    <fieldset class="ghost_setting_content_item">
                        <legend class="ghost_setting_content_item_title">
                            <span class="ghost_setting_content_primary">
                                <span class="poi-icon fa-user-circle fas fa-fw" aria-hidden="true"></span>
                                <span class="ghost_setting_content_text">下载链接</span></span>
                        </legend>
                        <div class="ghost_setting_content_item_content ghost_download">
                            <?php 
                                $download = get_post_meta($post_id,'ghost_download',true);
                                if(!empty($download)){
                                $i=0;
                                foreach($download as $downloads){
                            ?>
                                <div class="clearfix ghost_download_link">
                                    <div class="col-lg-2 float-left poi-g_lg-2-10">
                                        <label class="ghost_download_link_group_inputs">
                                            <span class="ghost_download_link_inputs_icon">
                                                <span class="poi-icon fa-cloud-download-alt fas fa-fw" aria-hidden="true"></span>
                                            </span>
                                            <span class="ghost_download_link_inputs_content">
                                                <input name="post_download_container[<?php echo $i; ?>][name]" class="ghost_setting_content_preface_control_downloadlink " type="text" placeholder="下载名称" title="下载名称" list="customPostStoragedatalist" placeholder="下载名称" value="<?php echo $downloads['name']; ?>"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-3 float-left poi-g_lg-2-10">
                                        <label class="ghost_download_link_group_inputs">
                                            <span class="ghost_download_link_inputs_icon">
                                                <span class="poi-icon fa-link fas fa-fw" aria-hidden="true"></span>
                                            </span>
                                            <span class="ghost_download_link_inputs_content">
                                                <input name="post_download_container[<?php echo $i; ?>][link]" class="ghost_setting_content_preface_control_downloadlink " type="text" placeholder="下载链接" title="下载链接" list="customPostStoragedatalist" placeholder="下载链接" value="<?php echo $downloads['link']; ?>"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-2 float-left poi-g_lg-1-10">
                                        <label class="ghost_download_link_group_inputs">
                                            <span class="ghost_download_link_inputs_icon">
                                                <span class="poi-icon fa-key fas fa-fw" aria-hidden="true"></span>
                                            </span>
                                            <span class="ghost_download_link_inputs_content">
                                                <input name="post_download_container[<?php echo $i; ?>][pwd]" class="ghost_setting_content_preface_control_downloadlink " type="text" placeholder="提取密码" title="提取密码" list="customPostStoragedatalist" placeholder="提取密码" value="<?php echo $downloads['pwd']; ?>"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-2 float-left poi-g_lg-1-10">
                                        <label class="ghost_download_link_group_inputs">
                                            <span class="ghost_download_link_inputs_icon">
                                                <span class="poi-icon fa-unlock fas fa-fw" aria-hidden="true"></span>
                                            </span>
                                            <span class="ghost_download_link_inputs_content">
                                                <input name="post_download_container[<?php echo $i; ?>][pwd2]" class="ghost_setting_content_preface_control_downloadlink " type="text" placeholder="解压密码" title="解压密码" list="customPostStoragedatalist" placeholder="解压密码" value="<?php echo $downloads['pwd2']; ?>"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-2 float-left poi-g_lg-1-10">
                                        <label class="ghost_download_link_group_inputs">
                                            <span class="ghost_download_link_inputs_icon">
                                                <span class="poi-icon fa-unlock fas fa-fw" aria-hidden="true"></span>
                                            </span>
                                            <span class="ghost_download_link_inputs_content">
                                                <input name="post_download_container[<?php echo $i++; ?>][credit]" class="ghost_setting_content_preface_control_downloadlink " type="text" placeholder="购买积分" title="购买积分" list="customPostStoragedatalist" placeholder="购买积分" value="<?php echo $downloads['credit']; ?>"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-1 float-left poi-g_lg-1-10">
                                        <div class="poi-btn-group ghost_download_link_storage_btns">
                                            <a class="link_add ghost_download_link_delete_btn">
                                                <span class="poi-icon fa-plus fas fa-fw" aria-hidden="true"></span>
                                            </a>
                                            <a class="link_del ghost_download_link_delete_btn" disabled="">
                                                <span class="poi-icon fa-trash fas fa-fw" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php }
											}else{ ?>
                            <div class="clearfix ghost_download_link">
                                    <div class="col-lg-2 float-left poi-g_lg-2-10">
                                        <label class="ghost_download_link_group_inputs">
                                            <span class="ghost_download_link_inputs_icon">
                                                <span class="poi-icon fa-cloud-download-alt fas fa-fw" aria-hidden="true"></span>
                                            </span>
                                            <span class="ghost_download_link_inputs_content">
                                                <input name="post_download_container[0][name]" class="ghost_setting_content_preface_control_downloadlink " type="text" placeholder="下载名称" title="下载名称" list="customPostStoragedatalist" placeholder="下载名称"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-3 float-left poi-g_lg-2-10">
                                        <label class="ghost_download_link_group_inputs">
                                            <span class="ghost_download_link_inputs_icon">
                                                <span class="poi-icon fa-link fas fa-fw" aria-hidden="true"></span>
                                            </span>
                                            <span class="ghost_download_link_inputs_content">
                                                <input name="post_download_container[0][link]" class="ghost_setting_content_preface_control_downloadlink " type="text" placeholder="下载链接" title="下载链接" list="customPostStoragedatalist" placeholder="下载链接"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-2 float-left poi-g_lg-1-10">
                                        <label class="ghost_download_link_group_inputs">
                                            <span class="ghost_download_link_inputs_icon">
                                                <span class="poi-icon fa-key fas fa-fw" aria-hidden="true"></span>
                                            </span>
                                            <span class="ghost_download_link_inputs_content">
                                                <input name="post_download_container[0][pwd]" class="ghost_setting_content_preface_control_downloadlink " type="text" placeholder="提取密码" title="提取密码" list="customPostStoragedatalist" placeholder="提取密码"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-2 float-left poi-g_lg-1-10">
                                        <label class="ghost_download_link_group_inputs">
                                            <span class="ghost_download_link_inputs_icon">
                                                <span class="poi-icon fa-unlock fas fa-fw" aria-hidden="true"></span>
                                            </span>
                                            <span class="ghost_download_link_inputs_content">
                                                <input name="post_download_container[0][pwd2]" class="ghost_setting_content_preface_control_downloadlink " type="text" placeholder="解压密码" title="解压密码" list="customPostStoragedatalist" placeholder="解压密码"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-2 float-left poi-g_lg-1-10">
                                        <label class="ghost_download_link_group_inputs">
                                            <span class="ghost_download_link_inputs_icon">
                                                <span class="poi-icon fa-unlock fas fa-fw" aria-hidden="true"></span>
                                            </span>
                                            <span class="ghost_download_link_inputs_content">
                                                <input name="post_download_container[0][credit]" class="ghost_setting_content_preface_control_downloadlink " type="text" placeholder="购买积分(0免费)" title="购买积分(0免费)" list="customPostStoragedatalist" placeholder="购买积分(0免费)"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-1 float-left poi-g_lg-1-10">
                                        <div class="poi-btn-group ghost_download_link_storage_btns">
                                            <a class="link_add ghost_download_link_delete_btn">
                                                <span class="poi-icon fa-plus fas fa-fw" aria-hidden="true"></span>
                                            </a>
                                            <a style="background: rgba(241,108,102,.7);color:#fff;cursor: not-allowed;" class="ghost_download_link_delete_btn" disabled="">
                                                <span class="poi-icon fa-trash fas fa-fw" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </fieldset>
                    <fieldset class="ghost_setting_content_item">
                        <legend class="ghost_setting_content_item_title">
                            <span class="ghost_setting_content_primary">
                                <span class="poi-icon fa-user-circle fas fa-fw" aria-hidden="true"></span>
                                <span class="ghost_setting_content_text">作品来源</span></span>
                        </legend>
                        <div class="ghost_setting_content_item_content">
                            <div class="ghost_setting_content_preface">
                                <p>本站默认作品为原创内容</p>
                            </div>
                            <div class="ghost_setting_content_my_avatar">
                            </div>
                        </div>
                    </fieldset>
                    <a style="padding: 8px;" data-postid="<?php echo $post_id; ?>" data-type="updatepost" class="submit_post ghost_setting_content_btn_success">
                        <span class="poi-icon fa-plus fas fa-fw" aria-hidden="true">提交</span>
                    </a>
                </div>
            </div>
            <script>
            jQuery(function ($) {
                // 文章图片上传
                $("#imgs_upload").change(function(e){
                $file = e.currentTarget.files[0];
                //结合formData实现图片预览
                var sendData=new FormData();
                // sendData.append('nonce',$nonce);
                sendData.append('action','upload_post_pic');
                sendData.append('file',$file);
                $.ajax({
                  url: ghost.ajaxurl,
                  type: 'POST',
                  cache: false,
                  data: sendData,
                  processData: false,
                  contentType: false
                }).done(function(res) {
                  if (res.code == 1) {
                      console.log(res.pic);
                    $pic = '<div class="ghost_my_pic"><div class="my_postimg"><img src="'+res.pic+'"></div><div class="pictype"><span class="add_post_container ghost_btn ghost_btn_success">插入文章</span><span class="ghost_btn ghost_btn_success">设为封面</span></div></div>'
                    $('.ghost_mypic').append($pic);
                    $.ghostalert_success(res.message,3000,false);
                  }else{
                    $.ghostalert_warning(res.message,3000,false);
                  }
                }).fail(function(res) {
                    $.ghostalert_error(res.message,3000,false);
                });
            
                $(this).empty();
              });
            })
            </script>
        </div>
    </div>
</div>
<?php require(get_template_directory().'/mod/me-footer.php');?>
<?php else:?>
    <div class="user_not_login"></div>
    <script>jQuery(function ($) {$('.user-login').trigger('click');});</script>
<?php endif;get_footer();?>