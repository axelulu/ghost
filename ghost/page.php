<?php 
/**
 * The template for displaying all page
 *
 * This is the template that displays all page by default.
 * Please note that this is the WordPress construct of page
 * and that other 'page' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ghost
 */
get_header();?>
<div class="main user_credit container">
		<div class="ghost_page_box single_post_body">
    <?php while ( have_posts() ) : the_post();
    the_content();
    endwhile;?>
    </div>
</div>
<?php get_footer();?>