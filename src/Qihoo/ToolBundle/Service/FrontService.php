<?php
namespace Qihoo\ToolBundle\Service;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * 前端缓存更新服务
 *
 */
class FrontService {
    
    private $container;
    private $masterRedis;
    private $webMachines;
    
    public function __construct(ContainerInterface $container, $masterRedis, $webMachines)
    {
        $this->container = $container;
        $this->masterRedis = $masterRedis;
        $this->webMachines = $webMachines;
    }

    // 异步更新手机首页缓存
    public function asyncMobileHome()
    {
    }
    
    // 更新手机首页缓存
    public function mobileHome($param = array())
    {
        $this->refreshRedis('inew_newgetrec_v2_*');
    }


    // 异步更新手机onebox的缓存
    public function asyncMobileOnebox()
    {
    }


    // 异步更新手机游戏精选页
    public function asyncMobileGameIndex()
    {
    }

    // 更新手机游戏精选页
    public function mobileGameIndex($param)
    {
    }


    // 异步更新手机软件精选页
    public function asyncMobileSoftIndex()
    {
    }


    // 更新手机软件精选页
    public function mobileSoftIndex($param)
    {
    }

    public function asyncMobileZhuantiSoft()
    {
    }

    public function mobileZhuantiSoft($param)
    {
    }

    public function asyncMobileZhuantiGame()
    {
    }

    public function mobileZhuantiGame($param)
    {
    }

    // 异步更新pc首页
    public function asyncPcIndex()
    {
    }

    // 异步更新pc首页
    public function asyncPcSoftIndex()
    {
    }

    public function asyncPcGameIndex()
    {
    }

    /**
     * 刷新今日热点
     * @return null
     */
    public function asyncPcHot($urls, $dirs = array())
    {
    }

    // 基础方法: 更新redis缓存
    public function refreshRedis($pattern)
    {
    }

    // 异步更新Url
    public function asyncRefreshUrl($type, $url)
    {
    }

    // 基础方法：更新url缓存
    public function refreshUrl($param)
    {
    }

    // 更新cdn缓存
    public function refreshCdn($params)
    {
    }

    // 快网的清除cdn的接口
    private function fPushSend($username, $md5, $url_arr, $dir_arr = null)
    {
    }
}
