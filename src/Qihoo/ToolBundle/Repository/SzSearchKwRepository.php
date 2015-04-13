<?php

namespace Qihoo\ToolBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * SzSearchKwRepository 
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SzSearchKwRepository extends EntityRepository
{
	public function getQuery($page, $pageSize, $params = array())
    {
        $page = intval($page);
        $pageSize = intval($pageSize);
        $em = $this->getEntityManager();
        $where = array();
        $sql = 'select * from sz_search_kw where day = \''.$params['day'].'\' order by search_time desc limit '. ($page-1)*$pageSize.", $pageSize";
        $totalSql = 'select count(*) as total from sz_search_kw where day = \''.$params['day'].'\'';
        $conn = $em->getConnection();
        $retTotal = $conn->fetchAssoc($totalSql);
        $ret = $conn->fetchAll($sql);
        $conn->close();
        return array($retTotal['total'], $ret);
    }

    public function queryAll($start, $limit, $params = array())
    {
        $em = $this->getEntityManager();
        $where = array();
        $sql = 'select * from sz_search_kw where day = \''.$params['day'].'\' order by search_time desc limit '. $start . ", $limit";
        $conn = $em->getConnection();
        $ret = $conn->fetchAll($sql);
        $conn->close();
        return $ret;
    }

    public function queryTodayBySearch($start, $limit, $params=array())
    {
        $em = $this->getEntityManager();
        $where = array();
        foreach ($params as $key => $value) {
            if($key == 'search_time') {
                $where[] = "$key >= $value";continue;
            }
            $where[] = "$key = '$value'";
        }
        $sql = 'select keyword, search_time from sz_search_kw where 
        keyword not in (select keyword from onebox_kw_ban) and keyword not in (select keyword from onebox_rec) '
        .(empty($where) ? '' : 'and '.implode(' and ', $where))
        .' order by search_time desc limit '. ($start-1)*$limit . ", $limit";
        #var_dump($sql,$params);exit;
        $totalSql = 'select count(*) total from sz_search_kw where 
        keyword not in (select keyword from onebox_kw_ban) and keyword not in (select keyword from onebox_rec) '
        .(empty($where) ? '' : 'and '.implode(' and ', $where));
        $conn = $em->getConnection();
        $retTotal = $conn->fetchAssoc($totalSql);
        $ret = $conn->fetchAll($sql);
        $conn->close();
        return array($retTotal['total'] , $ret);
    }
}