<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package pink
 */

?>
<aside id="ghost_widget" class="ghost_widget">
	<div class="ghost_widget_content">
		<?php
			if(is_home()){
				dynamic_sidebar( 'sidebar_index' );
			}elseif(is_singular('post')){
				dynamic_sidebar( 'sidebar_post' );
			}elseif(is_page()){
				dynamic_sidebar( 'sidebar_page' );
			}
		?>
	</div>
</aside><!-- #secondary -->
