<script>
jQuery(function ($) {
    window.onpopstate = function(e) {
        pathName = window.location.pathname;
        var projectName = pathName.substring(pathName.substr(1).indexOf('/')+2, pathName.substr(4).indexOf('/') + 4);
        $('.ghost_sidebar_item_sub_item_link[data-type="'+projectName+'"]').trigger('click');
        history.pushState(null,null,ghost.siteurl+'/me/'+projectName+'/');
    }
})
</script>