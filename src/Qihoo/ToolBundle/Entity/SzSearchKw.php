<?php

namespace Qihoo\ToolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SzSearchKw
 *
 * @ORM\Table(name="sz_search_kw")
 * @ORM\Entity(repositoryClass="Qihoo\ToolBundle\Repository\SzSearchKwRepository")
 */
class SzSearchKw
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
     * @var string
     *
     * @ORM\Column(name="keyword", type="string", length=80, nullable=false)
     */
    private $keyword;

    /**
     * @var integer
     *
     * @ORM\Column(name="search_time", type="integer", nullable=false)
     */
    private $searchTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="search_people", type="integer", nullable=false)
     */
    private $searchPeople;

    /**
     * @var integer
     *
     * @ORM\Column(name="down_time", type="integer", nullable=false)
     */
    private $downTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="down_people", type="integer", nullable=false)
     */
    private $downPeople;

    /**
     * @var integer
     *
     * @ORM\Column(name="pre7_display", type="integer", nullable=false)
     */
    private $pre7Display;

    /**
     * @var integer
     *
     * @ORM\Column(name="pre7_down", type="integer", nullable=false)
     */
    private $pre7Down;



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
     * @return SzSearchKw
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
     * Set keyword
     *
     * @param string $keyword
     * @return SzSearchKw
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
     * Set searchTime
     *
     * @param integer $searchTime
     * @return SzSearchKw
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
     * Set searchPeople
     *
     * @param integer $searchPeople
     * @return SzSearchKw
     */
    public function setSearchPeople($searchPeople)
    {
        $this->searchPeople = $searchPeople;
    
        return $this;
    }

    /**
     * Get searchPeople
     *
     * @return integer 
     */
    public function getSearchPeople()
    {
        return $this->searchPeople;
    }

    /**
     * Set downTime
     *
     * @param integer $downTime
     * @return SzSearchKw
     */
    public function setDownTime($downTime)
    {
        $this->downTime = $downTime;
    
        return $this;
    }

    /**
     * Get downTime
     *
     * @return integer 
     */
    public function getDownTime()
    {
        return $this->downTime;
    }

    /**
     * Set downPeople
     *
     * @param integer $downPeople
     * @return SzSearchKw
     */
    public function setDownPeople($downPeople)
    {
        $this->downPeople = $downPeople;
    
        return $this;
    }

    /**
     * Get downPeople
     *
     * @return integer 
     */
    public function getDownPeople()
    {
        return $this->downPeople;
    }

    /**
     * Set pre7Display
     *
     * @param integer $pre7Display
     * @return SzSearchKw
     */
    public function setPre7Display($pre7Display)
    {
        $this->pre7Display = $pre7Display;
    
        return $this;
    }

    /**
     * Get pre7Display
     *
     * @return integer 
     */
    public function getPre7Display()
    {
        return $this->pre7Display;
    }

    /**
     * Set pre7Down
     *
     * @param integer $pre7Down
     * @return SzSearchKw
     */
    public function setPre7Down($pre7Down)
    {
        $this->pre7Down = $pre7Down;
    
        return $this;
    }

    /**
     * Get pre7Down
     *
     * @return integer 
     */
    public function getPre7Down()
    {
        return $this->pre7Down;
    }
}