<?php

namespace Qihoo\ToolBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * @author wukai
 */
class AssetsHistoryRepository extends EntityRepository
{
    public function getList($assetsId)
    {
        return $this->getEntityManager()
                ->createQuery("SELECT ah FROM QihooToolBundle:AssetsHistory ah WHERE ah.assetsId=:assetsId ORDER BY ah.fetchTime DESC")
                ->setParameter('assetsId', $assetsId)
                ->getResult();
    }
}
