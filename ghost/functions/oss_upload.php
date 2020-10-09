<?php
/**
 * 文件上传
 * @description
 * @param        $file
 * @param string $path
 * @param        $max_size
 * @param        $allowExt
 * @return mixed
 */
function upload_File($file,$oss_dir = '',$path = __DIR__.'/temp',$user_id){
    $filename=$file['name'];
    $temp_name=$file['tmp_name'];
    $error=$file['error'];
    $res = [];
    if ($error==UPLOAD_ERR_OK) {
        // if ($size>$max_size) {
        //     $res['mes']=$filename."文件超过规定上传大小";
        // }
        $ext = getExt($filename);
        if (in_array($ext, array('exe'))) {
            $res['mes']=$filename.'非法的文件';
        }
        if (!is_uploaded_file($temp_name)) {
            $res['mes']=$filename."文件不是通过HTTP POST 方法上传上传过来的";
        }

        if ($res) {
            return  $res;
        }

        if (!file_exists($path)) {
            mkdir($path,0777,true);
            chmod($path, 0777);
        }
        $filename = get_uniqid($user_id);
        $destination = $path.'/'.$filename.'.'.$ext;
        if (move_uploaded_file($temp_name, $destination)) {
            $res['mes'] = $filename.'上传成功';
            $res['dest'] = $destination;
            $res['fname'] = $oss_dir.'/'.$filename.'.'.$ext;
            $res['file_name'] = $filename.'.'.$ext;
        }else{
            $res['mes']=$filename."文件上传失败";
        }
    }else{
        switch ($error) {
            case '1':
                $res['mes']="超过了配置文件上传文件的大小";
                break;
            case '2':
                $res['mes']="超过表单设置上传文件文件的大小";
                break;
            case '3':
                $res['mes']="文件部分被上传";
                break;
            case '4':
                $res['mes']="没有文件被上传";

                break;
            case '6':
                $res['mes']="没有找到临时目录";
                break;
            case '7':
                $res['mes']="文件不可写";

                break;
            default:
                $res['mes']="上传文件失败";
                break;
        }
    }

    return $res;

}
/**
 * 获得文件扩展名
 * @param  string $filename 上传文件名
 * @return string           返回扩展名
 */
function getExt($filename){
    $arr=explode('.', basename($filename));

    return end($arr);
}
/**
 * 生成唯一字符串
 * author: xiaochuan
 * return: string
 */
function get_uniqid($user_id)
{
    return $user_id.'-'.md5(uniqid(rand(), true));
}
 

/**
 * 整理多个文件
 * @description
 * @return mixed
 */
function getFiles(){
    $files = array();
    foreach($_FILES as $file){
        $fileNum=count($file['name']);
        for ($i=0; $i < $fileNum; $i++) {
            $files[$i]['name']=$file['name'][$i];
            $files[$i]['type']=$file['type'][$i];
            $files[$i]['tmp_name']=$file['tmp_name'][$i];
            $files[$i]['error']=$file['error'][$i];
            $files[$i]['size']=$file['size'][$i];
        }
    }
    return $files;
}

?>