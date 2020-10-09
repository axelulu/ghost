<?php 
date_default_timezone_set('Asia/Shanghai');
$require_url=get_template_directory();

require($require_url.'/functions/ghost.php');
require($require_url.'/functions/function.php');
require($require_url.'/functions/redis.php');
require($require_url.'/functions/user.php');
require($require_url.'/functions/msg.php');
require($require_url.'/functions/oss_upload.php');
require($require_url.'/functions/AliyunOss.php');
require_once $require_url.'/admin/module/options.php';

if(is_admin()){
}else{

//mobile
if(wp_is_mobile()){
require($require_url.'/functions/mobile.php');
}
}

// 移除admin bar
add_filter('show_admin_bar', '__return_false');


/*
*去除分类标志代码
*/
if( ghost_get_option('switch_category') ){
    add_action( 'load-themes.php',  'no_category_base_refresh_rules');   
    add_action('created_category', 'no_category_base_refresh_rules');   
    add_action('edited_category', 'no_category_base_refresh_rules');   
    add_action('delete_category', 'no_category_base_refresh_rules');   
    function no_category_base_refresh_rules() {       
        global $wp_rewrite;   
        $wp_rewrite -> flush_rules();   
    }   
    // Remove category base   
    add_action('init', 'no_category_base_permastruct');   
    function no_category_base_permastruct() {   
        global $wp_rewrite, $wp_version;   
        if (version_compare($wp_version, '3.4', '<')) {   
            // For pre-3.4 support   
            $wp_rewrite -> extra_permastructs['category'][0] = '%category%';   
        } else {   
            $wp_rewrite -> extra_permastructs['category']['struct'] = '%category%';   
        }   
    }   
      
    // Add our custom category rewrite rules   
    add_filter('category_rewrite_rules', 'no_category_base_rewrite_rules');   
    function no_category_base_rewrite_rules($category_rewrite) {   
        //var_dump($category_rewrite); // For Debugging   
      
        $category_rewrite = array();   
        $categories = get_categories(array('hide_empty' => false));   
        foreach ($categories as $category) {   
            $category_nicename = $category -> slug;   
            if ($category -> parent == $category -> cat_ID)// recursive recursion   
                $category -> parent = 0;   
            elseif ($category -> parent != 0)   
                $category_nicename = get_category_parents($category -> parent, false, '/', true) . $category_nicename;   
            $category_rewrite['(' . $category_nicename . ')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category_name=$matches[1]&feed=$matches[2]';   
            $category_rewrite['(' . $category_nicename . ')/page/?([0-9]{1,})/?$'] = 'index.php?category_name=$matches[1]&paged=$matches[2]';   
            $category_rewrite['(' . $category_nicename . ')/?$'] = 'index.php?category_name=$matches[1]';   
        }   
        // Redirect support from Old Category Base   
        global $wp_rewrite;   
        $old_category_base = get_option('category_base') ? get_option('category_base') : 'category';   
        $old_category_base = trim($old_category_base, '/');   
        $category_rewrite[$old_category_base . '/(.*)$'] = 'index.php?category_redirect=$matches[1]';   
      
        //var_dump($category_rewrite); // For Debugging   
        return $category_rewrite;   
    }   
      
      
    // Add 'category_redirect' query variable   
    add_filter('query_vars', 'no_category_base_query_vars');   
    function no_category_base_query_vars($public_query_vars) {   
        $public_query_vars[] = 'category_redirect';   
        return $public_query_vars;   
    }   
      
    // Redirect if 'category_redirect' is set   
    add_filter('request', 'no_category_base_request');   
    function no_category_base_request($query_vars) {   
        //print_r($query_vars); // For Debugging   
        if (isset($query_vars['category_redirect'])) {   
            $catlink = trailingslashit(get_option('home')) . user_trailingslashit($query_vars['category_redirect'], 'category');   
            status_header(301);   
            header("Location: $catlink");   
            exit();   
        }   
        return $query_vars;   
    }
  }

//   -----------------------------------------------------------------------------结束-----------------------------------------------------------------------------
//   -----------------------------------------------------------------------------结束-----------------------------------------------------------------------------

//检测主题更新
require 'theme-updates/theme-update-checker.php';
$example_update_checker = new ThemeUpdateChecker(
    'Ghost',
    'https://catacg.cn/ghost/ghost_update.json '
);

?>
