<?php
// src/Qihoo/ToolBundle/Controller/AssetsController.php

namespace Qihoo\ToolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Qihoo\ToolBundle\Entity\Assets;
use Qihoo\ToolBundle\Entity\AssetsHistory;

/**
 * @author wukai
 * 大团队资产管理
 * @Route("/assets")
 */
class AssetsController extends Controller
{
    /**
     * @Route("/list", name="tool_assets_list")
     * @Template("QihooToolBundle:Assets:list.html.twig")
     */
    public function listAction()
    {
        $p  = 1;
        $pn = 10;

        $request = $this->getRequest();

        list($total, $data) = $this->fetchData($p, $pn);

        $totalPages = (int)(($total + $pn -1) / $pn);

        return array (
            "total"      => $total,
            "totalPages" => $totalPages,
            "p"          => $p,
            "pn"         => $pn,
            'data'       => $data,
        );
    }

    /**
     * @Route("/query", name="tool_assets_query")
     * @Template("QihooToolBundle:Assets:query_result.html.twig")
     */
    public function queryAction()
    {
        $request     = $this->getRequest();
        $queryParams = $this->getQueryParams($request);

        $p  = (int)$request->get("p");
        $pn = (int)$request->get("pn");

        $p  = $p <= 0 ? 1 : $p;
        $pn = $pn <=0 ? 10 : $pn;

        list($total, $data) = $this->fetchData($p, $pn, $queryParams);

        $totalPages = (int)(($total + $pn -1) / $pn);

        return array (
            "total"      => $total,
            "totalPages" => $totalPages,
            "p"          => $p,
            "pn"         => $pn,
            'data'       => $data,
        );
    }

    /**
     * @Route("/info", name="tool_assets_info")
     * @Template("QihooToolBundle:Assets:info.html.twig")
     */
    public function infoActon()
    {
        $request = $this->getRequest();
        $id      = $request->get('id');
        $em      = $this->getDoctrine()->getEntityManager();
        $assets  = $em->getRepository('QihooToolBundle:Assets')->find($id);

        $historyRepository = $this->getDoctrine()->getRepository('QihooToolBundle:AssetsHistory');
        $assetsHistory     = $historyRepository->getList($id);

        return array('assets' => $assets, 'assetsHistory' => $assetsHistory);
    }

    /**
     * @Route("/add", name="tool_assets_add")
     * @Template("QihooToolBundle:Assets:add.html.twig")
     */
    public function addAction()
    {
        $request  = $this->getRequest();
        $id       = $request->get('id');
        $confirm  = $request->get('confirm');
        $operator = $this->getUser()->getUserName();

        if ($id) {
            $em = $this->getDoctrine()->getEntityManager();
            $assets = $em->getRepository('QihooToolBundle:Assets')->find($id);
        } else {
            $assets = new Assets();
        }

        if ($confirm) {
            $now = new \DateTime();
            $returnTime = new \DateTime($request->get('returnTime'));
            $em  = $this->getDoctrine()->getEntityManager();
            $assets->setType($request->get('type'));
            $assets->setBrand($request->get('brand'));
            $assets->setModelType($request->get('modelType'));
            $assets->setState($request->get('state'));
            $assets->setMemory($request->get('memory'));
            $assets->setIdentifier($request->get('identifier'));
            $assets->setSn($request->get('sn'));
            $assets->setImei($request->get('imei'));
            $assets->setSdcard($request->get('sdcard'));
            $assets->setDataline($request->get('dataline'));
            $assets->setEarline($request->get('earline'));
            $assets->setGuarantee($request->get('guarantee'));
            $assets->setOther($request->get('other'));
            $assets->setDepartment($request->get('department'));
            $assets->setOwner($request->get('owner'));
            $assets->setFetchTime($now);
            $assets->setWhouse($request->get('whouse'));
            $assets->setReturnTime($returnTime);
            $assets->setReturnState($request->get('returnState'));
            $assets->setNote($request->get('note'));
            $assets->setOperator($operator);
            $assets->setUpdateTime($now);
            if (!$id) {
                $assets->setCreateTime($now);
            }
            $em->persist($assets);
            $em->flush();

            $em->persist($this->setHistory($assets));
            $em->flush();

            return new JsonResponse(array("code" => 0, "msg" => "success"));
        } else {
            return array('assets' => $assets);
        }
    }

    /**
     * @Route("/delete", name="tool_assets_delete")
     */
    public function deleteAction()
    {
        $request  = $this->getRequest();
        $id = $request->get('id');
        $em = $this->getDoctrine()->getEntityManager();
        $assets = $em->getRepository('QihooToolBundle:Assets')->find($id);

        $em->remove($assets);
        $em->flush();

        return new JsonResponse(array("code" => 0, "msg" => "success"));
    }


    /**
     * @Route("/export", name="tool_assets_export")
     */
    public function exportAction()
    {
        $request     = $this->getRequest();
        $queryParams = $this->getQueryParams($request);

        list($total, $data) = $this->fetchData(1, 100000000, $queryParams); //取所有

        $titles = array (
            'id'          => '资产ID',
            'type'        => '类型',
            'brand'       => '品牌',
            'modelType'   => '类型',
            'state'       => '手机状态',
            'memory'      => '机身存储',
            'identifier'  => '机器资产编号',
            'sn'          => 'S/N',
            'imei'        => 'IMEI',
            'sdcard'      => 'SD卡',
            'dataline'    => '数据线',
            'power'       => '电源',
            'battery'     => '电池',
            'earline'     => '耳机线',
            'guarantee'   => '保修卡',
            'other'       => '其他',
            'department'  => '领用人所在部门',
            'owner'       => '领用人',
            'fetchTime'  => '领用时间',
            'whouse'      => '具体使用人',
            'returnTime'  => '归还时间',
            'returnState' => '归还时手机状态',
            'note' => '备注',
        );

        foreach ($titles as $title => &$chinese) {
            $chinese = iconv('utf-8', 'gbk', $chinese);
        }

        $content = array();
        foreach ($data as $k => $v) {
            $one = array();
            foreach ($titles as $title => $chinese) {
                if (in_array($title, array('returnTime', 'fetchTime'))) {
                    $titleValue = get_object_vars($v->{"get{$title}"}());
                    $titleValue = $titleValue['date'];
                } else {
                    $titleValue = iconv('utf-8','gbk',$v->{"get{$title}"}());
                }
                $one[$title] = $titleValue;
            }
            $content[] = $one;
        }

        array_unshift($content, array_values($titles));

        $fileName = '资产表.xls';
        header("Content-Type: text/plain; charset=gbk");
        header("Content-Disposition: attachment; filename=" . $fileName);
        foreach ($content as $line) {
            echo implode("\t", $line) . "\n";
        }
        exit;
    }

    /**
     * 获取数据
     * @param   int    $p
     * @param   int    $pn
     * @param   array  $queryParams
     * @return  array  例如：('total' => $total, 'data' => $data)
     */
    private function fetchData($p, $pn, $queryParams = array())
    {
        $em     = $this->getDoctrine()->getManager();
        $result = $em->getRepository('QihooToolBundle:Assets')->getList($p, $pn, $queryParams);

        return $result;
    }

    /**
     * 资产管理的操作记录
     * @param   boject   $assets
     * @return  \Qihoo\ToolBundle\Entity\AssetsHistory
     */
    private function setHistory($assets)
    {
        $assetsHistory = new AssetsHistory();
        $assetsHistory->setAssetsId($assets->getId());
        $assetsHistory->setOwner($assets->getOwner());
        $assetsHistory->setDepartment($assets->getDepartment());
        $assetsHistory->setFetchTime($assets->getFetchTime());
        $assetsHistory->setWhouse($assets->getWhouse());
        $assetsHistory->setReturnState($assets->getReturnState());

        return $assetsHistory;
    }

    /**
     * 获取查询参数
     * @param   object   $request
     * @return  array
     */
    private function getQueryParams($request)
    {
        $queryParams = array();
        if ($request->get('brand')) {
            $queryParams['brand'] = $request->get('brand');
        }
        if ($request->get('modelType')) {
            $queryParams['modelType'] = $request->get('modelType');
        }
        if ($request->get('department')) {
            $queryParams['department'] = $request->get('department');
        }
        if ($request->get('owner')) {
            $queryParams['owner'] = $request->get('owner');
        }

        return $queryParams;
    }
}