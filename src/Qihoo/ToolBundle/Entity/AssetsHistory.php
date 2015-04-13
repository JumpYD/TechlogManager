<?php

namespace Qihoo\ToolBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * 资产管理历史记录
 * @author wukai
 * @ORM\Entity(repositoryClass="Qihoo\ToolBundle\Repository\AssetsHistoryRepository")
 * @ORM\Table(name="qihoo_assets_history")
 */
class AssetsHistory
{
    /**
     * @ORM\OneToMany(targetEntity="Assets", mappedBy="AssetsHistory")
     *
    protected $assets;

    public function __construct()
    {
        $this->assets = new ArrayCollection();
    }*/

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="assets_id", type="integer")
     */
    private $assetsId;

    /**
     * @ORM\Column(type="string")
     */
    private $owner;

    /**
     * @ORM\Column(type="string")
     */
    private $department;

    /**
     * @ORM\Column(name="fetch_time", type="datetime")
     */
    private $fetchTime;

    /**
     * @ORM\Column(type="string")
     */
    private $whouse;

    /**
     * @ORM\Column(name="return_state", type="string")
     */
    private $returnState;

    /**
     * Set id
     *
     * @param integer $id
     * @return AssetsHistory
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }

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
     * Set owner
     *
     * @param string $owner
     * @return AssetsHistory
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    
        return $this;
    }

    /**
     * Get owner
     *
     * @return string 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set department
     *
     * @param string $department
     * @return AssetsHistory
     */
    public function setDepartment($department)
    {
        $this->department = $department;
    
        return $this;
    }

    /**
     * Get department
     *
     * @return string 
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set fetchTime
     *
     * @param \DateTime $fetchTime
     * @return AssetsHistory
     */
    public function setFetchTime($fetchTime)
    {
        $this->fetchTime = $fetchTime;
    
        return $this;
    }

    /**
     * Get fetchTime
     *
     * @return \DateTime 
     */
    public function getFetchTime()
    {
        return $this->fetchTime;
    }

    /**
     * Set whouse
     *
     * @param string $whouse
     * @return AssetsHistory
     */
    public function setWhouse($whouse)
    {
        $this->whouse = $whouse;
    
        return $this;
    }

    /**
     * Get whouse
     *
     * @return string 
     */
    public function getWhouse()
    {
        return $this->whouse;
    }

    /**
     * Set returnState
     *
     * @param string $returnState
     * @return AssetsHistory
     */
    public function setReturnState($returnState)
    {
        $this->returnState = $returnState;
    
        return $this;
    }

    /**
     * Get returnState
     *
     * @return string 
     */
    public function getReturnState()
    {
        return $this->returnState;
    }

    /**
     * Set assetsId
     *
     * @param integer $assetsId
     * @return AssetsHistory
     */
    public function setAssetsId($assetsId)
    {
        $this->assetsId = $assetsId;
    
        return $this;
    }

    /**
     * Get assetsId
     *
     * @return integer 
     */
    public function getAssetsId()
    {
        return $this->assetsId;
    }
}