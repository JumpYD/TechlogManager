<?php

class ChimaSDK
{
    public static function saveDeviceInfo($info)
    {
        $data = json_decode($info, true);
        if(empty($data) || !is_array($data)){
            return false;
        }

        $key_map = array(
            'recovery' => 'recovery',
            'system' => '/system',
            'data' => '/data',
            'cache' => '/cache',
            'recovery_img' => 'file',
            'model' => 'model',
            'manufacturer' => 'manufacturer',
            'version' => 'system_version',
            'func_type' => 'func_type',
            );

        foreach ($key_map as $k => $v) {
            if($k === 'func_type'){
                $device[$k] = isset($data[$v]) ? intval($data[$v]) : 0;
                !in_array($device[$k], array(0, 1)) and $device[$k] = 0;
            } else {
                $device[$k] = isset($data[$v]) ? trim($data[$v]) : '';
            }
        }

        //todo:判断是否需要入库
        $model = $device['model'];
        $manufacturer = $device['manufacturer'];
        $recovery_img = $device['recovery_img'];
        if(!empty($recovery_img) && !file_exists($recovery_img)){
            return false;
        }

        # status 机型状态
        # 0: 未处理，1：待审核，9：已上线
        $info = self::check($model, $manufacturer);
        if($info === false){
            return false;
        }

        $status = isset($info['status']) ? $info['status'] : '';
        $old_version = isset($info['version']) ? $info['version'] : '';
        if(intval($status) > 0){
            # 不需要入库
            return true;
        }

        # 上传recovery_img及deivce信息
        $device['recovery_img'] = $manufacturer . '_' . $model . '.img';
        $device['recovery_img_content'] = "@".$recovery_img;

        if($status === ''){
            $ret = self::update($device, 'insert');
        } elseif ($status === 0) {
            if (stripos($old_version, $device['version']) !== false) {
                unset($device['version']);
            } elseif (!empty($old_version)) {
                $device['version'] = $old_version . ',' . $device['version'];
            }
            $device['query_opt'] = 'update';
            $ret = self::update($device, 'update');
        } else {
            return false;
        }
        return $ret;
    }

    private static function check($model, $manufacturer)
    {
        $url = 'http://10.16.21.214:8362/api/customization/device_update';
        $data = array('model'=>$model, 'manufacturer'=>$manufacturer, 'query_opt'=>'check');
        list($info, $ret) = self::myCurl($url, $data);
        $info = json_decode($info, true);
        if(!is_array($info) || (isset($info['code']) && $info['code'] === 1)){
            return false;
        }
        return $info;
    }

    private static function update($device, $opt)
    {
        $url = 'http://10.16.21.214:8362/api/customization/device_update';
        $device['query_opt'] = $opt;
        list($info, $ret) = self::myCurl($url, $device);
        $info = json_decode($info, true);
        if(isset($info['code']) && $info['code'] === 0){
            return true;
        }
        return false;
    }

    private static function myCurl($url, $data, $headers = null){
        $ch = curl_init();
        if ($headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        $http_content = curl_exec($ch);
        $http_ret = curl_getinfo($ch);
        curl_close($ch);
        return array($http_content, $http_ret);
    }
}

?>
