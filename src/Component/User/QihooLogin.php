<?php
namespace Component\User;
use Component\Exception\CurlException;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * qihoo用户登陆的封装
 * @author tianye-s
 */
class QihooLogin {
    private $container;
    private $mainUrl;
    private $slaveUrl;
    public function __construct(ContainerInterface $container=null, $mainUrl=null, $slaveUrl=null)
    {
        $this->container = $container;
        $this->mainUrl = $mainUrl;
        $this->slaveUrl = $slaveUrl;
    }

    private function testServer($curl, $server)
    {
    }

    private function getCleanUri($request)
    {
    }

    public function login($sid="")
    {
    }
}
