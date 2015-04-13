<?php

namespace Qihoo\ToolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SzSearchTotal
 *
 * @ORM\Table(name="sz_search_total")
 * @ORM\Entity(repositoryClass="Qihoo\ToolBundle\Repository\SzSearchTotalRepository")
 */
class SzSearchTotal
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
     * @var \DateTime
     *
     * @ORM\Column(name="day", type="date", nullable=false)
     */
    private $day;

    /**
     * @var integer
     *
     * @ORM\Column(name="search_time", type="integer", nullable=false)
     */
    private $searchTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="search_down", type="integer", nullable=false)
     */
    private $searchDown;

    /**
     * @var integer
     *
     * @ORM\Column(name="detail_down", type="integer", nullable=false)
     */
    private $detailDown;



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
     * Set day
     *
     * @param \DateTime $day
     * @return SzSearchTotal
     */
    public function setDay($day)
    {
        $this->day = $day;
    
        return $this;
    }

    /**
     * Get day
     *
     * @return \DateTime 
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set searchTime
     *
     * @param integer $searchTime
     * @return SzSearchTotal
     */
    public function setSearchTime($searchTime)
    {
        $this->searchTime = $searchTime;
    
        return $this;
    }

    /**
     * Get searchTime
     *
     * @return integer 
     */
    public function getSearchTime()
    {
        return $this->searchTime;
    }

    /**
     * Set searchDown
     *
     * @param integer $searchDown
     * @return SzSearchTotal
     */
    public function setSearchDown($searchDown)
    {
        $this->searchDown = $searchDown;
    
        return $this;
    }

    /**
     * Get searchDown
     *
     * @return integer 
     */
    public function getSearchDown()
    {
        return $this->searchDown;
    }

    /**
     * Set detailDown
     *
     * @param integer $detailDown
     * @return SzSearchTotal
     */
    public function setDetailDown($detailDown)
    {
        $this->detailDown = $detailDown;
    
        return $this;
    }

    /**
     * Get detailDown
     *
     * @return integer 
     */
    public function getDetailDown()
    {
        return $this->detailDown;
    }
}