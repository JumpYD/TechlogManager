<?php
namespace Component\Log;

use Qihoo\MonitorBundle\Entity\MonitorOperateLog;

/**
 * monitor平台日志封装
 * @author lizishi@360.cn
 */
class Log
{
    static function insertLog($em, $route, $description, $id, $user_name, $log_action = '')
    {
    	\date_default_timezone_set('PRC');
    	$operate_log_entity = new MonitorOperateLog();
    	$operate_log_entity->setDescription($description);
    	$operate_log_entity->setRoute($route);

        if( $log_action == '' )
        {
    	    if($id != ''){
    	    	$action = 'modify';
    	    }else{
    	    	$action = 'insert';
    	    }
        }
        else
            $action = $log_action;

    	$operate_log_entity->setAction($action);
    	$operate_log_entity->setCreateTime(date('Y-m-d H:i:s'));
    	$operate_log_entity->setOperator($user_name);
    	$em->persist($operate_log_entity);
    	$em->flush();
    }
}
