<?php

namespace Qihoo\ToolBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * @author wukai
 */
class FeedBackRepository extends EntityRepository
{
    public function getList($start, $limit, $params = array())
    {
        $start = (int)$start;
        $limit = (int)$limit;
        $start = $start <= 0 ? 1 : $start;
        $limit = $limit <= 0 ? 10 : $limit;

        $em = $this->getEntityManager();

        $DQL_TOTAL = "SELECT COUNT(a) FROM QihooToolBundle:FeedBack a";
        $DQL = "SELECT a FROM QihooToolBundle:FeedBack a";

        $WHERE = array();

        if (isset($params['startTime'])) {
            $WHERE[] = "a.createTime>=:startTime";
        }
        if (isset($params['endTime'])) {
            $WHERE[] = "a.createTime<=:endTime";
        }
        if (isset($params['state'])) {
            $WHERE[] = "a.state=:state";
        }
        if (isset($params['version'])) {
            $WHERE[] = "a.version=:version";
        }
        if (isset($params['operator'])) {
            $WHERE[] = "a.operator=:operator";
        }
        if (isset($params['question'])) {
            $params['question'] = "%{$params['question']}%";
            $WHERE[] = "a.question like :question";
        }

        $WHERE  = $WHERE ? " WHERE " . implode(" AND ", $WHERE) : '';
        $WHERE .= " ORDER BY a.createTime DESC";

        $query_total = $em->createQuery($DQL_TOTAL . $WHERE);
        $query       = $em->createQuery($DQL . $WHERE);

        $query_total->setParameters($params);
        $query->setParameters($params);

        $total  = (int)$query_total->getSingleScalarResult();
        $first  = ($start - 1) * $limit;
        $query->setFirstResult($first); //设置起始元素
        $query->setMaxResults($limit);

        return array($total, $query->getResult());
    }
}
