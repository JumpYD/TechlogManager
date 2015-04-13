<?php

namespace Qihoo\ToolBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Qihoo\ToolBundle\Entity\AutoDownUrl;

/**
 * AutoDownUrl controller.
 *
 * @Route("/tool_autodownurl")
 */
class AutoDownUrlController extends Controller
{

    /**
     * Lists all AutoDownUrl entities.
     *
     * @Route("/", name="tool_autodownurl")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('QihooToolBundle:AutoDownUrl')->getAllList();
        return array(
            'entities' => $entities,
        );
    }

    private function getJsonResponse($code, $result) {
        $json = array(
            "code" => $code,
            "result" => $result,
        );
        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * add a new AutoDownUrl entity.
     * @Route("/add", name="tool_autodownurl_add")
     * @Method("POST")
     * @Template("QihooToolBundle:AutoDownUrl:list.html.twig")
     */
    public function addAction(Request $request)
    {
        $url = $request->get("url");
        if (!$url) {
            return $this->getJsonResponse(1, "url参数为空!");
        }
        if (strpos($url, "http://") === false) {
            return $this->getJsonResponse(2, "不是有效的url格式（需要有http://前缀)");
        }

        $em = $this->getDoctrine()->getManager();
        $entity = new AutoDownUrl($url);
        $em->persist($entity);
        $em->flush();

        $entities = $em->getRepository('QihooToolBundle:AutoDownUrl')->getAllList();
        $content = $this->renderView(
            'QihooToolBundle:AutoDownUrl:list.html.twig',
            array('entities' => $entities)
        );
        return $this->getJsonResponse(0, $content);
    }

    /**
     * add a new AutoDownUrl entity.
     * @Route("/del", name="tool_autodownurl_del")
     * @Method("POST")
     * @Template("QihooToolBundle:AutoDownUrl:list.html.twig")
     */
    public function delAction(Request $request)
    {
        $id = (int)$request->get("id");
        if (!$id) {
            return $this->getJsonResponse(1, "id参数为空!");
        }
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('QihooToolBundle:AutoDownUrl')->find($id);
        if (!$entity) {
            return $this->getJsonResponse(2, "id ($id) 在数据库不存在!(是否已经删除?)");
        }
        $em->remove($entity);
        $em->flush();
        return $this->getJsonResponse(0, ""); //删除成功
    }

}
