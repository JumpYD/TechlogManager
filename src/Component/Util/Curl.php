<?php
namespace Component\Util;
/**
 * curl使用的类
 */
class Curl {
    /**
     * post数据
     * @param string $url 服务链接
     * @param string $data 数据
     * @param array $headers 需要设置的的http header
     * @return array
     */
    public static function post($url, $data, $headers=array(), $maxTime=600) {
        $ch = curl_init();
        if ($headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $maxTime);
        $ret = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        return array($info, $ret);
    }

    /**
     * get请求
     * @param string $url 服务端链接
     * @param array $params 请求参数
     * @param array $headers 需要设置的的http header
     * @param int $maxTime 最大执行时间（秒）
     * @return array($info, $ret)
     */
    public static function get($url, $params=array(), $headers=array(), $maxTime=300) {
        $ch = curl_init();
        if ($params) {
            if (strpos($url, '?') > 0) {
                $url .= "&".http_build_query($params);
            } else {
                $url .= "?".http_build_query($params);
            }
        }
        if ($headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $maxTime);
        $ret = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        return array($info, $ret);
    }

    /**
     * head请求（例如查询链接状态），最大执行时间为10秒
     * @param string $url 查询链接
     * @return array
     */
    public static function head($url, $maxTime=10) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $maxTime);
        curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        return $info;
    }
    
    /**
     * 下载文件
     * @param string $url 下载的url
     * @param string $savePath 保存的路径
     * @param array $headers 需要设置的的http header
     * @param int $maxTime 最大执行时间（秒），设置大点，有的文件下载很慢
     */
    public static function download($url, $savePath, $headers=array(), $maxTime=1200) {
        $fp = fopen($savePath, "w");
        $ch = curl_init();
        if ($headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $maxTime);
        curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        fclose($fp);
        return $info;
    }

    /**
     * 发送文件
     * @param string $url 提交链接
     * @param string $filePath 文件路径
     * @param array $headers http header
     * @param string $defaultName 默认上传名
     * @return array
     */
    public static function sendFile($url, $filePath, $headers=array(), $defaultName="file") {
        $postData = array(
            "$defaultName" => "@".$filePath,
        );
        return self::post($url, $postData, $headers);
    }
}
