<?php
/**
 * @Class: AliyunOss.php
 * @Description: 控制器
 * @Date: 2019/10/16
 */
header("Content-Type:text/html;charset=utf-8");
error_reporting(E_ALL);

if (is_file(__DIR__ . '/aliyun_oss/autoload.php')) {
    require_once __DIR__ . '/aliyun_oss/autoload.php';
}
function classLoader($class)
{
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = __DIR__ . DIRECTORY_SEPARATOR. $path . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
}
spl_autoload_register('classLoader');


use OSS\OssClient;
use OSS\Core\OssException;

// 阿里云主账号AccessKey拥有所有API的访问权限，风险很高。强烈建议您创建并使用RAM账号进行API访问或日常运维，请登录 https://ram.console.aliyun.com 创建RAM账号。

class AliyunOss
{
    private $accessKeyId;
    private $accessKeySecret;
    private $endpoint;
    private $bucket;

    public function __construct()

    {
        // require_once __DIR__ . '/aliyun_oss/config.php';
        $this->accessKeyId = ghost_get_option('ghost_oss_accessKeyId');
        $this->accessKeySecret = ghost_get_option('ghost_oss_accessKeySecret');
        // Endpoint以杭州为例，其它Region请按实际情况填写。 $endpoint="http://oss-cn-hangzhou.aliyuncs.com";
        $this->endpoint = ghost_get_option('ghost_oss_endpoint');
        // 存储空间名称
        $this->bucket = ghost_get_option('ghost_oss_bucket');
    }
    public function upload_file($file_path, $file_name)
    {
        try {
            $ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint, true);
            $result = $ossClient->uploadFile($this->bucket, $file_name, $file_path);//$result['info']['url'] 返回上传成功的oss文件地址
            $arr = array(
                'oss_file' =>$result['info']['url'],
                'local_path' => $file_name
            );
            return $arr;
        } catch (OssException $e) {
            // printf(__FUNCTION__ . ": FAILED\n");
            // printf($e->getMessage() . "\n");
            log_msg('文件上传失败',$e->getMessage());
            log_msg('文件上传失败',$file_path.'---'.$file_name);
            return false;
        }
    }
}