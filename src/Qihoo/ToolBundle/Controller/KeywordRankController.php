<?php

namespace Qihoo\ToolBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Qihoo\ToolBundle\Entity\KeywordRank;
use Component\Exception\ParamException;
use Doctrine\DBAL\DBALException;

/**
 * @Route("/keywordrank")
 */
class KeywordRankController extends Controller
{
    /**
     * @Route("/list", name="tool_keyword_list")
     * @Template("QihooToolBundle:KeywordRank:list.html.twig")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager("sjbb");
        $p = 1;
        $pn = 1000;
        list($total, $entities) = $em->getRepository('QihooToolBundle:KeywordRank')->getList($p, $pn);
        $totalPages = (int)(($total + $pn -1) / $pn);
        return array(
            "total" => $total,
            "totalPages" => $totalPages,
            "p" => $p,
            "pn" => $pn,
            'entities' => $entities,
        );
    }

    /**
     *
     * @Route("/new", name="tool_keyword_new")
     * @Template("QihooToolBundle:KeywordRank:update.html.twig")
     */
    public function newAction()
    {
        $request = $this->getRequest();
        $keyword = $request->get("keyword");
        $softIdList = $request->get("soft_id_list");

        $entity = new KeywordRank();
        if (!$keyword || !$softIdList) {
            return array(
                "error" => "",
                "kw_readonly" => "",
                "entity" => $entity);
        }

        $entity->setKeyword($keyword);
        $entity->setSoftIdList($softIdList);
        $softIdStr = str_replace(array(","," "), "", $softIdList);
        if (!ctype_digit($softIdStr)) {
            return array(
                "error" => "提交失败：soft_id非法，请修改后再提交",
                "kw_readonly" => "",
                "entity" => $entity);
        }
        $em = $this->getDoctrine()->getEntityManager("sjbb");
        $em->getConnection()->executeQuery("set names utf8");
        $res = $em->getRepository('QihooToolBundle:KeywordRank')->findOneByKeyword($keyword);
        if ($res) {
            return array(
                "error" => "提交失败：该关键词已存在",
                "kw_readonly" => "",
                "entity" => $entity);
        }

        $entity->setOperator($this->getUser()->getUsername());
        $em->persist($entity);
        $em->flush();

        $response = $this->forward('QihooToolBundle:keywordrank:list');
        return $response;
    }

    /**
     *
     * @Route("/modify", name="tool_keyword_modify")
     * @Template("QihooToolBundle:KeywordRank:update.html.twig")
     */
    public function modifyAction()
    {
        $request = $this->getRequest();
        $id = $request->get("id");
        if (!$id) {
            throw new ParamException("id is empty!");
        }

        $em = $this->getDoctrine()->getEntityManager("sjbb");
        $em->getConnection()->executeQuery("set names utf8");
        $entity = $em->getRepository('QihooToolBundle:KeywordRank')->find($id);

        $keyword = $request->get("keyword");
        $softIdList = $request->get("soft_id_list");
        if (!$keyword || !$softIdList) {
            return array(
                "entity" => $entity,
                "kw_readonly" => "readonly",
                "error" => "",
            );
        }

        $entity->setKeyword($keyword);
        $entity->setSoftIdList($softIdList);
        $softIdStr = str_replace(array(","," "), "", $softIdList);
        if (!ctype_digit($softIdStr)) {
            return array(
                "error" => "提交失败：soft_id非法，请修改后再提交",
                "kw_readonly" => "readonly",
                "entity" => $entity);
        }

        $entity->setOperator($this->getUser()->getUsername());

        $em->persist($entity);
        $em->flush();

        $response = $this->forward('QihooToolBundle:keywordrank:list');
        return $response;
    }

    /**
     * 执行删除
     *  @Route("/delete", name="tool_keyword_delete")
     */
    public function deleteAction()
    {
        $request  = $this->getRequest();
        $id = $request->get('id');
        $em = $this->getDoctrine()->getEntityManager("sjbb");
        $assets = $em->getRepository('QihooToolBundle:KeywordRank')->find($id);

        $em->remove($assets);
        $em->flush();
        $response = $this->forward('QihooToolBundle:keywordrank:list');
        return $response;
    }
}
