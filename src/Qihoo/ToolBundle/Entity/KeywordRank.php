<?php

namespace Qihoo\ToolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KeywordRank
 *
 * @ORM\Table(name="keyword_rank")
 * @ORM\Entity(repositoryClass="Qihoo\ToolBundle\Repository\KeywordRankRepository")
 */
class KeywordRank
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="keyword", type="string", length=128, nullable=false)
     */
    private $keyword;

    /**
     * @var string
     *
     * @ORM\Column(name="soft_id_list", type="string", length=256, nullable=false)
     */
    private $softIdList;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="edit_time", type="datetime", nullable=false)
     */
    private $editTime;

    /**
     * @var string
     *
     * @ORM\Column(name="operator", type="string", length=64, nullable=false)
     */
    private $operator;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set keyword
     *
     * @param string $keyword
     * @return KeywordRank
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;
    
        return $this;
    }

    /**
     * Get keyword
     *
     * @return string 
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * Set softIdList
     *
     * @param string $softIdList
     * @return KeywordRank
     */
    public function setSoftIdList($softIdList)
    {
        $this->softIdList = $softIdList;
    
        return $this;
    }

    /**
     * Get softIdList
     *
     * @return string 
     */
    public function getSoftIdList()
    {
        return $this->softIdList;
    }

    /**
     * Set editTime
     *
     * @param \DateTime $editTime
     * @return KeywordRank
     */
    public function setEditTime($editTime)
    {
        $this->editTime = $editTime;
    
        return $this;
    }

    /**
     * Get editTime
     *
     * @return \DateTime 
     */
    public function getEditTime()
    {
        return $this->editTime;
    }

    /**
     * Set operator
     *
     * @param string $operator
     * @return KeywordRank
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;
    
        return $this;
    }

    /**
     * Get operator
     *
     * @return string 
     */
    public function getOperator()
    {
        return $this->operator;
    }
}
