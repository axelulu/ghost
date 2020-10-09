jQuery(function($) {
// 灯箱
    $(".single_post_body img").each(function(i) {
       if (!this.parentNode.href) {
          $(this).wrap("<a href='" + this.src + "' data-fancybox='fancybox' data-caption='" + this.alt + "'></a>")
       }
    })

    // 头像上传
    $(".main").on('change','#my_avatar',function(e){
        $.ghostalert_loading(2000,false);
        $nonce = $(this).attr("data-nonce");
        $file = e.currentTarget.files[0];
    
        //结合formData实现图片预览
        var sendData=new FormData();
        sendData.append('nonce',$nonce);
        sendData.append('action','update_avatar_photo');
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
            $.ghostalert_success(res.message,3000,true);
          }else{
            $.ghostalert_warning(res.message,3000,true);
          }
        }).fail(function(res) {
            $.ghostalert_error(res.message,3000,true);
        });
    
    });


})