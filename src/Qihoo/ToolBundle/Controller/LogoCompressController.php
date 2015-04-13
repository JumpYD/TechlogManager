<?php

namespace Qihoo\ToolBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/tool_logocompress")
 */
class LogoCompressController extends Controller {
    /**
     * 首页
     * @Route("/index", name="tool_logocompress_index")
     * @Template("QihooToolBundle:LogoCompress:index.html.twig")
     */
    public function indexAction() {
        return array();
    }
    
    /**
     * 上传图片
     * @Route("/uploadimage", name="tool_logocompress_uploadimage")
     */
    public function uploadImageAction() {
        
    }
    
    private function getJsonResult($code, $msg, $data = array()) {
        return new JsonResponse(array("code" => $code, "msg" => $msg, "data" => $data));
    }

}
