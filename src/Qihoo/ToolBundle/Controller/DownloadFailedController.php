<?php
namespace Qihoo\ToolBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 * DownloadFailed controller.
 *
 * @Route("/download_failed")
 */
class DownloadFailedController extends Controller
{
    /**
     * Lists all DownloadFailed entities.
     *
     * @Route("/index", name="tool_downloadfailed_list")
     * @Template("QihooToolBundle:DownloadFailed:list.html.twig")
     */
    public function indexAction()
    {
        $pageSize = 50;
        $request  = $this->getRequest();
        $month    = $request->get('month');
        $connectionManager = $this->getDoctrine()->getManager('sjbb');
        if (!is_numeric($month) || $month < 1 || $month > 12)
        {
            $month = date('m');
        }
        else
        {
            $month = substr('0' . $month, -2);
        }

        $db = $connectionManager->getConnection();
        $entities = $db->query('SELECT * FROM open_download_failed_day WHERE day>=' . date('Y') . $month . '01 AND day<=' . date('Y') . $month . '31 ORDER BY day DESC');
        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists One Day DownloadFailed entities.
     *
     * @Route("/detail", name="tool_downloadfailed_detail")
     * @Template("QihooToolBundle:DownloadFailed:detail.html.twig")
     */
    public function detailAction()
    {
        $statuses = array(
            // 正常状态
            '190' => '下载挂起',
            '192' => '正在下载',
            '193' => '用户暂停',
            '196' => '用户正在暂停',
            '197' => '正在合并增量包',
            '200' => '下载成功',

            // 非正常状态
            '400' => '服务器返回400状态码',
            '406' => 'STATUS_NOT_ACCEPTABLE',
            '411' => 'STATUS_LENGTH_REQUIRED',
            '412' => '服务器返回412',
            '468' => '包文件已经存在',
            '480' => '服务器返回300-400之间的某个错误码',
            '481' => '获取包信息失败',
            '487' => 'SD卡不存在',
            '488' => '磁盘空间不足',
            '489' => '断点续传错误(期待返回206却返回200)',
            '490' => '用户取消下载',
            '491' => '手机客户端访问网络异常',             //此类错误需要再根据日志中的failInfo字段进行分析
            '492' => '写文件失败',
            '493' => '增量包合并失败',
            '494' => '网络有问题,未知的服务器状态码',
            '495' => '网络不通无法下载',
            '496' => '服务器返回496',
            '497' => '302跳转次数超过5次',
            '498' => '服务器返回498错误码',
            '499' => '超过最大失败重试次数', // 此类错误需要再根据日志中的failInfo字段进行分析
            '503' => '服务器返回503',
            '-2'  => '手机客户端未知错误',
        );

        $request = $this->getRequest();
        $day = $request->get('day');
        $connectionManager = $this->getDoctrine()->getManager('sjbb');
        if (!is_numeric($day))
        {
            $day = date('Ymd', strtotime('-1 day'));
        }
        $db = $connectionManager->getConnection();
        $statement = $db->query("SELECT * FROM open_download_failed_day WHERE day='" . $day . "'");
        $row = $statement->fetch(\PDO::FETCH_ASSOC);
        $entities = array();
        if (is_array($row) && isset($row['Id']))
        {
            $sum = 0;
            $statusCounts = json_decode($row['data'], True);
            foreach ($statusCounts as $k => $v)
            {
                $statusCounts[$k] = intval($v);
            }
            arsort($statusCounts);
            foreach ($statusCounts as $status=>$count)
            {
                $item = array();
                if (isset($statuses[$status]))
                {
                    $item['status'] = $statuses[$status];
                    $item['count'] = $count;
                    $entities[] = $item;
                }
                $sum += $count;
            }
            foreach ($entities as $k => $item)
            {
                $entities[$k]['rate'] = sprintf("%01.4f", $item['count']/$sum * 100);
            }
        }

        return array(
            'entities' => $entities,
        );
    }

    // 获取当年某个月的天数
    private function getDays($month)
    {
        if (is_numeric($month) && $month>0 && $month<13)
        {
            $month = substr('0' . $month, -2);
        }
        else
        {
            $month = date('m');
        }
        return date('t', strtotime(date('Y') . '-' . $month . '-01'));
    }
}