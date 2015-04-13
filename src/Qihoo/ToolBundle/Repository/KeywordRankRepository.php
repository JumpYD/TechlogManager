<?php

namespace Qihoo\ToolBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * 
 * @author pengwei
 */
class KeywordRankRepository extends EntityRepository
{
    public function getList($p, $pn)
    {
        $p = (int)$p;
        $pn = (int)$pn;
        $p = $p <= 0 ? 1 : $p;
        $pn = $pn <= 0 ? 10 : $pn;
        $em = $this->getEntityManager("sjbb");
        $em->getConnection()->executeQuery("set names utf8");
        $totalDql = "SELECT COUNT(p) FROM QihooToolBundle:KeywordRank p where 1=1";
        $dql = "SELECT p FROM QihooToolBundle:KeywordRank p where 1=1";
        
        $where .= " order by p.editTime desc";
        $totalQuery = $em->createQuery($totalDql.$where);
        $query = $em->createQuery($dql.$where);
        
        $total = (int)$totalQuery->getSingleScalarResult();
        $first = ($p - 1) * $pn;
        $query->setFirstResult($first); //设置起始元素
        $query->setMaxResults($pn);
        return array($total, $query->getResult());
        
    }
}
