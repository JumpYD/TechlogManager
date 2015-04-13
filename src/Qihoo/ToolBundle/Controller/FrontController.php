<?php

namespace Qihoo\ToolBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Component\Exception\ParamException;
use Doctrine\DBAL\DBALException;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/front")
 */
class FrontController extends Controller
{

    /**
     * @Route("/list", name="tool_front_renew_list")
     * @Template("QihooToolBundle:Front:list.html.twig")
     */
    public function listAction()
    {
        return array();
    }

    /**
     * @Route("/refresh_submit", name="tool_front_renew_refresh_submit")
     */
    public function refreshSubmitAction()
    {
        return new JsonResponse(array("code" => 0));
    }
}
