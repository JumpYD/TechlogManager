<?php

namespace Qihoo\ToolBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * @author wukai
 */
class AssetsRepository extends EntityRepository
{
    public function getList($p, $pn, $params = array())
    {
        return $this->query($p, $pn, $params);
    }

    private function query($p, $pn, $params)
    {
        $p  = (int)$p;
        $pn = (int)$pn;
        $p  = $p <= 0 ? 1 : $p;
        $pn = $pn <= 0 ? 10 : $pn;

        $em = $this->getEntityManager();

        $DQL_TOTAL = "SELECT COUNT(a) FROM QihooToolBundle:Assets a";
        $DQL = "SELECT a FROM QihooToolBundle:Assets a";

        $WHERE = array();
        if (isset($params['brand'])) {
            $params['brand'] = "%{$params['brand']}%";
            $WHERE[] = "a.brand like :brand";
        }
        if (isset($params['modelType'])) {
            $params['modelType'] = "%{$params['modelType']}%";
            $WHERE[] = "a.modelType like :modelType";
        }
        if (isset($params['department'])) {
            $params['department'] = "%{$params['department']}%";
            $WHERE[] = "a.department like :department";
        }
        if (isset($params['owner'])) {
            $WHERE[] = "a.owner=:owner";
        }

        $WHERE = $WHERE ? " WHERE " . implode(" AND ", $WHERE) : '';
        $WHERE .= " ORDER BY a.fetchTime DESC";

        $query_total = $em->createQuery($DQL_TOTAL . $WHERE);
        $query       = $em->createQuery($DQL . $WHERE);

        $query_total->setParameters($params);
        $query->setParameters($params);

        $total  = (int)$query_total->getSingleScalarResult();
        $first  = ($p - 1) * $pn;
        $query->setFirstResult($first); //设置起始元素
        $query->setMaxResults($pn);

        return array($total, $query->getResult());
    }
}
