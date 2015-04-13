<?php

namespace Qihoo\ToolBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Qihoo\ToolBundle\Entity\SzSearchKw;
use Qihoo\ToolBundle\Entity\SzSearchTotal;

/**
 * @author lvyanpeng
 * @Route("/sz_search")
 */
class SzSearchController extends Controller
{
    public $defaultPage = 1;
    public $defaultPageSize = 20;

    private function getEM()
    {
        return $this->getDoctrine()->getEntityManager('sjbb');
    }

    /**
     * @Route("/list", name="tool_szsearch_list")
     * @Template("QihooToolBundle:SzSearch:list.html.twig")
     */
    public function listAction ()
    {
        $request = $this->getRequest();
        $params = $this->getQueryParams($request);
        $em = $this->getEM();
        $page = $this->defaultPage;
        $pageSize = $this->defaultPageSize; //limit
        list($total, $totals) = $em->getRepository('QihooToolBundle:SzSearchTotal')
            ->getQuery($page, $pageSize, $params);
        $totalPages = ceil($total / $pageSize);
        return array(
            'total' => $total,
            'totalPages' => $totalPages,
            'page' => $page,
            'pageSize' => $pageSize,
            'entities' => $totals,
        );
    }

    /**
     * @Route("/query", name="tool_szsearch_query")
     * @Template("QihooToolBundle:SzSearch:query_result.html.twig")
     */
    public function queryAction()
    {
        $request = $this->getRequest();
        $params = $this->getQueryParams($request);
        $page = ($request->get("page") < 1) ? $this->defaultPage : $request->get("page");
        $pageSize = ($request->get("page_size") < 1) ? $this->defaultPageSize : $request->get("page_size");
        $em = $this->getEM();
        list($total, $totals) = $em->getRepository('QihooToolBundle:SzSearchTotal')
            ->getQuery($page, $pageSize, $params);
        $totalPages = ceil($total / $pageSize);
        return array(
            'total' => $total,
            'totalPages' => $totalPages,
            'page' => $page,
            'pageSize' => $pageSize,
            'entities' => $totals,
        );
    }

    protected function getQueryParams($request)
    {
        $params = array();
        $begin = $request->get('begin');
        $end = $request->get('end');
        $params['begin'] = empty($begin) ? '2013-08-01' : date('Y-m-d', strtotime($begin));
        $params['end']   = empty($end)   ? date('Y-m-d', strtotime( date("H")<7?'-2 days':'yesterday')) : date('Y-m-d', strtotime($end));
        return $params;
    }

    /**
     * @Route("/detail", name="tool_szsearch_detail")
     * @Template("QihooToolBundle:SzSearch:detail.html.twig")
     */
    public function detailAction()
    {
        $day = $this->getRequest()->get('day');
        $em = $this->getEM();
        $page = $this->defaultPage;
        $pageSize = $this->defaultPageSize; //limit
        list($total, $totals) = $em->getRepository('QihooToolBundle:SzSearchKw')
            ->getQuery($page, $pageSize, array('day'=>$day));
        $totalPages = ceil($total / $pageSize);
        return array(
            'total' => $total,
            'totalPages' => $totalPages,
            'page' => $page,
            'pageSize' => $pageSize,
            'entities' => $totals,
        );
    }
    /**
     * @Route("/detail_query", name="tool_szsearch_dquery")
     * @Template("QihooToolBundle:SzSearch:detailquery.html.twig")
     */
    public function detailQueryAction()
    {
        $request = $this->getRequest();
        $day = $request->get('day');
        $em = $this->getEM();
        $page = ($request->get("page") < 1) ? $this->defaultPage : $request->get("page");
        $pageSize = ($request->get("page_size") < 1) ? $this->defaultPageSize : $request->get("page_size");
        list($total, $totals) = $em->getRepository('QihooToolBundle:SzSearchKw')
            ->getQuery($page, $pageSize, array('day'=>$day));
        $totalPages = ceil($total / $pageSize);
        return array(
            'total' => $total,
            'totalPages' => $totalPages,
            'page' => $page,
            'pageSize' => $pageSize,
            'entities' => $totals,
        );
    }

    /**
     * @Route("/exportkw", name="tool_szsearch_exportkw")
     */
    public function exportkwAction()
    {
        set_time_limit(0);
        $request     = $this->getRequest();
        $params = array();
        $params['day'] = $request->get('day');
        try {
            $em = $this->getEM();

            $fileName = $day.'关键字数据表.xls';
            header("Content-Type: application/octet-stream; charset=gbk");
            header("Content-Disposition: attachment; filename=" . $fileName);
            $header = array('id', 'day', 'keyword', 'search_time', 'search_people', 'down_time', 'down_people', 'pre7_display', 'pre7_down');
            echo implode("\t", $header ). "\n";
            $start = 0; 
            $limit = 5000;
            while(true) {
                $data = $em->getRepository('QihooToolBundle:SzSearchKw')->queryAll($start, $limit, $params);
                if (!$data) {
                    break;
                }

                foreach ($data as $line) {
                    $line['keyword'] = mb_convert_encoding($line['keyword'], 'gbk', 'utf-8');
                    echo implode("\t", $line) . "\n";
                }

                $start += $limit;
            }
        } catch (\Exception $e) {
            $msg = $e->getFile() . ":" . $e->getLine() . ":" . $e->getMessage();
            $this->get("logger")->addError($msg);
            var_dump($msg);
        }
        exit;
    }
}
