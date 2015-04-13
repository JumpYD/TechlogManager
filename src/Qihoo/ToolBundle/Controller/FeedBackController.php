<?php
// src/Qihoo/ToolBundle/Controller/FeedBackController.php

namespace Qihoo\ToolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Qihoo\ToolBundle\Entity\FeedBack;

/**
 * @author wukai
 * 反馈管理
 * @Route("/feedback")
 */
class FeedBackController extends Controller
{
    /**
     * @Route("/list", name="tool_feedback_list")
     * @Template("QihooToolBundle:FeedBack:list.html.twig")
     */
    public function listAction()
    {
        $start = 1;
        $limit = 10;

        $request = $this->getRequest();

        list($total, $data) = $this->fetchData($start, $limit);

        $totalPages = (int)(($total + $limit -1) / $limit);

        return array (
            "total"      => $total,
            "totalPages" => $totalPages,
            "start"      => $start,
            "limit"      => $limit,
            'data'       => $data,
        );
    }

    /**
     * @Route("/query", name="tool_feedback_query")
     * @Template("QihooToolBundle:FeedBack:query_result.html.twig")
     */
    public function queryAction()
    {
        $request     = $this->getRequest();
        $queryParams = $this->getQueryParams($request);

        $start = (int)$request->get("start");
        $limit = (int)$request->get("limit");

        $start = $start <= 0 ? 1 : $start;
        $limit = $limit <=0 ? 10 : $limit;

        list($total, $data) = $this->fetchData($start, $limit, $queryParams);

        $totalPages = (int)(($total + $limit -1) / $limit);

        return array (
            "total"      => $total,
            "totalPages" => $totalPages,
            "start"      => $start,
            "limit"      => $limit,
            'data'       => $data,
        );
    }

    /**
     * @Route("/info", name="tool_feedback_info")
     * @Template("QihooToolBundle:FeedBack:info.html.twig")
     */
    public function infoActon()
    {
        $request  = $this->getRequest();
        $id       = $request->get('id');
        $em       = $this->getDoctrine()->getEntityManager();
        $feedback = $em->getRepository('QihooToolBundle:FeedBack')->find($id);

        return array('feedback' => $feedback);
    }

    /**
     * @Route("/add", name="tool_feedback_add")
     * @Template("QihooToolBundle:FeedBack:add.html.twig")
     */
    public function addAction()
    {
        $request  = $this->getRequest();
        $id       = $request->get('id');
        $confirm  = $request->get('confirm');
        $operator = $this->getUser()->getUserName();

        if ($id) {
            $em = $this->getDoctrine()->getEntityManager();
            $feedback = $em->getRepository('QihooToolBundle:FeedBack')->find($id);
        } else {
            $feedback = new FeedBack();
        }

        if ($confirm) {
            $now = new \DateTime();
            $em  = $this->getDoctrine()->getEntityManager();
            $feedback->setQuestion($request->get('question'));
            $feedback->setVersion($request->get('version'));
            $feedback->setState((int)$request->get('state'));
            $feedback->setProcess($request->get('process'));
            $feedback->setOperator($operator);
            $feedback->setUpdateTime($now);
            if (!$id) {
                $feedback->setCreateTime($now);
            }
            $em->persist($feedback);
            $em->flush();

            return new JsonResponse(array("code" => 0, "msg" => "success"));
        } else {
            return array('feedback' => $feedback);
        }
    }

    /**
     * @Route("/delete", name="tool_feedback_delete")
     */
    public function deleteAction()
    {
        $request  = $this->getRequest();
        $id = $request->get('id');
        $em = $this->getDoctrine()->getEntityManager();
        $feedback = $em->getRepository('QihooToolBundle:FeedBack')->find($id);

        $em->remove($feedback);
        $em->flush();

        return new JsonResponse(array("code" => 0, "msg" => "success"));
    }

    /**
     * 获取数据
     * @param   int    $start
     * @param   int    $limit
     * @param   array  $queryParams
     * @return  array  例如：('total' => $total, 'data' => $data)
     */
    private function fetchData($start, $limit, $queryParams = array())
    {
        $em     = $this->getDoctrine()->getManager();
        $result = $em->getRepository('QihooToolBundle:FeedBack')->getList($start, $limit, $queryParams);

        return $result;
    }

    /**
     * 获取查询参数
     * @param   object   $request
     * @return  array
     */
    private function getQueryParams($request)
    {
        $queryParams = array();
        if ($request->get('operator')) {
            $queryParams['operator'] = $request->get('operator');
        }
        if ($request->get('startTime')) {
            $queryParams['startTime'] = $request->get('startTime');
        }
        if ($request->get('endTime')) {
            $queryParams['endTime'] = $request->get('endTime');
        }
        if ($request->get('question')) {
            $queryParams['question'] = $request->get('question');
        }
        if ($request->get('state')) {
            $queryParams['state'] = $request->get('state');
        }
        if ($request->get('version')) {
            $queryParams['version'] = $request->get('version');
        }

        return $queryParams;
    }
}