<?php

namespace Qihoo\ToolBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AutoDownUrlRepository extends EntityRepository
{
    public function getAllList()
    {
        return $this->getEntityManager()
                ->createQuery("SELECT p FROM QihooToolBundle:AutoDownUrl p ORDER BY p.startTime desc")
                ->getResult();
    }

    /**
     * 获取新加入列表
     */
    public function getNewAddList()
    {
        return $this->getEntityManager()
                ->createQuery("SELECT p FROM QihooToolBundle:AutoDownUrl p where p.state=0 ORDER BY p.startTime desc")
                ->getResult();
    }
}
