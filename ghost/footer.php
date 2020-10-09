<?php 
$footer_links = '';
foreach(ghost_get_option('ghost_footer_links') as $links){
	$footer_links .= '<li class="ghost-footer-link"><a class="ghost-footer-links" href="'.$links['ghost_footer_link'].'">'.$links['ghost_footer_text'].'</a></li>';
}
if(!wp_is_mobile()): ?>
<script>
jQuery(function($) {
    // 顶部滚动菜单
    $(document).scroll(function() {
        var top1 = $(".main").offset().top;
        var gun = $(document).scrollTop();
        if(top1-gun-50<=0){
            $('.scroll-header-menu').removeClass('container');
            $('.navigation').addClass('container');
            $('#scroll-header').addClass('header_menu_top');
            $('.ghost-header-logo').css('width','100%');
        }
        if(top1-gun-50>0){
            $('.scroll-header-menu').addClass('container');
            $('.navigation').removeClass('container');
            $('#scroll-header').removeClass('header_menu_top');
            $('.ghost-header-logo').css('width','');
        }
    })
$(".single_more_posts").each(function(index,element) {
    element.onwheel = function(event){
        event.preventDefault();  
            //设置鼠标滚轮滚动时屏幕滚动条的移动步长  
            var step = 150;  
            if(event.deltaY < 0){  
                //向上滚动鼠标滚轮，屏幕滚动条左移  
                this.scrollLeft -= step;  
            } else {  
                //向下滚动鼠标滚轮，屏幕滚动条右移  
                this.scrollLeft += step;  
            }  
    }
})
})
</script>
<footer class="footer">
    <div class="footer-wrap">
        <!-- 页脚菜单/版权信息 IDC No. -->
        <div class="footer-nav">
		  <div class="ghost-footer-width">
		  <div class="ghost-footer">
		  <aside>
			<div class="widget widget_text">
			  <div class="heading">
				<i class="fas fa-link"></i><span class="widget-title">链接导航</span>
			  </div>
			  <div class="textwidget">
				<ul class="ghost-links-daohang">
				<?php echo $footer_links; ?>
				</ul>
			  </div>
			</div>
		  </aside>
		  </div>
		 <div class="ghost-footer">
		  <aside>
			<div class="widget widget_text">
			  <div class="heading">
				<i class="fas fa-bullhorn"></i><span class="widget-title">声明</span>
			  </div>
			  <div class="textwidget"><?php echo ghost_get_option('ghost_site_footer_shenming') ?></div>
			</div>
		  </aside>
		  </div>
		  <div class="ghost-footer">
		  <aside>
			<div class="widget widget_text">
			  <div class="heading">
				<i class="fas fa-user-circle"></i><span class="widget-title">关于我们</span>
			  </div>
			  <div class="textwidget"><?php echo ghost_get_option('ghost_site_footer_about') ?></div>
			</div>
		  </aside>
		  </div>
		  <div class="ghost-footer">
		  <aside>
			<div class="widget widget_text">
			  <div class="heading">
				<i class="fas fa-envelope"></i><span class="widget-title">联系我们</span>
			  </div>
			  <div class="textwidget"><?php echo ghost_get_option('ghost_site_footer_contact') ?></div>
			</div>
		  </aside>
		  </div>
			</div>
        </div>
    </div>
</footer>
<?php endif;
?>
<div class="ghost_bottom_tools">
    <div class="container">
        <div class="ghost_bottom_tools_container">
            <div class="ghost_bottom_tool_container">
				<div class="ghost_bottom_tools_top_item">
					<a class="ghost_bottom_tools_top_link" title="返回顶部"><span class="ghost_bottom_tools_top_icon poi-icon fa-arrow-up fas fa-fw" aria-hidden="true"></span> 
					<span class="ghost_bottom_tools_top_text">返回顶部</span>
					</a>
				</div>
			</div>
        </div>
    </div>
</div>
<?php wp_footer();?>
<div class="ghost_footer"><?php echo ghost_get_option('ghost_site_footer').online_user().'   查询：'.get_num_queries().'次   耗时：'.timer_stop(0,3).'秒'; ?></div>
<script>
(function(){
var src = "https://jspassport.ssl.qhimg.com/11.0.1.js?d182b3f28525f2db83acfaaf6e696dba";
document.write('<script src="' + src + '" id="sozz"><\/script>');
})();
</script>
</body>
</html>