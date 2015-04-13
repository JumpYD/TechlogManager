<?php

namespace Qihoo\ToolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 资产管理
 * @author wukai
 * @ORM\Entity(repositoryClass="Qihoo\ToolBundle\Repository\AssetsRepository")
 * @ORM\Table(name="qihoo_assets")
 */
class Assets
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $type;

    /**
     * @ORM\Column(type="string")
     */

    private $brand;
    /**
     * @ORM\Column(name="model_type", type="string")
     */
    private $modelType;

    /**
     * @ORM\Column(type="string")
     */
    private $state;

    /**
     * @ORM\Column(type="string")
     */
    private $memory;

    /**
     * @ORM\Column(type="string")
     */
    private $identifier;

    /**
     * @ORM\Column(type="string")
     */
    private $sn;

    /**
     * @ORM\Column(type="string")
     */
    private $imei;

    /**
     * @ORM\Column(type="string")
     */
    private $sdcard;

    /**
     * @ORM\Column(type="string")
     */
    private $dataline;

    /**
     * @ORM\Column(type="string")
     */
    private $power;

    /**
     * @ORM\Column(type="string")
     */
    private $battery;

    /**
     * @ORM\Column(type="string")
     */
    private $earline;

    /**
     * @ORM\Column(type="string")
     */
    private $guarantee;

    /**
     * @ORM\Column(type="string")
     */
    private $other;

    /**
     * @ORM\Column(type="string")
     */
    private $department;

    /**
     * @ORM\Column(type="string")
     */
    private $owner;

    /**
     * @ORM\Column(name="fetch_time", type="datetime")
     */
    private $fetchTime;

    /**
     * @ORM\Column(type="string")
     */
    private $whouse;

    /**
     * @ORM\Column(name="return_time", type="datetime")
     */
    private $returnTime;

    /**
     * @ORM\Column(name="return_state", type="string")
     */
    private $returnState;

    /**
     * @ORM\Column(type="string")
     */
    private $note;

    /**
     * @ORM\Column(type="string")
     */
    private $operator;

    /**
     * @ORM\Column(name="update_time", type="datetime")
     */
    private $updateTime;

    /**
     * @ORM\Column(name="create_time", type="datetime")
     */
    private $createTime;

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
     * Set type
     *
     * @param string $type
     * @return Assets
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set brand
     *
     * @param string $brand
     * @return Assets
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    
        return $this;
    }

    /**
     * Get brand
     *
     * @return string 
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set modelType
     *
     * @param string $modelType
     * @return Assets
     */
    public function setModelType($modelType)
    {
        $this->modelType = $modelType;
    
        return $this;
    }

    /**
     * Get modelType
     *
     * @return string 
     */
    public function getModelType()
    {
        return $this->modelType;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Assets
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set memory
     *
     * @param string $memory
     * @return Assets
     */
    public function setMemory($memory)
    {
        $this->memory = $memory;
    
        return $this;
    }

    /**
     * Get memory
     *
     * @return string 
     */
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     * @return Assets
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    
        return $this;
    }

    /**
     * Get identifier
     *
     * @return string 
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set sn
     *
     * @param string $sn
     * @return Assets
     */
    public function setSn($sn)
    {
        $this->sn = $sn;
    
        return $this;
    }

    /**
     * Get sn
     *
     * @return string 
     */
    public function getSn()
    {
        return $this->sn;
    }

    /**
     * Set imei
     *
     * @param string $imei
     * @return Assets
     */
    public function setImei($imei)
    {
        $this->imei = $imei;
    
        return $this;
    }

    /**
     * Get imei
     *
     * @return string 
     */
    public function getImei()
    {
        return $this->imei;
    }

    /**
     * Set sdcard
     *
     * @param string $sdcard
     * @return Assets
     */
    public function setSdcard($sdcard)
    {
        $this->sdcard = $sdcard;
    
        return $this;
    }

    /**
     * Get sdcard
     *
     * @return string 
     */
    public function getSdcard()
    {
        return $this->sdcard;
    }

    /**
     * Set dataline
     *
     * @param string $dataline
     * @return Assets
     */
    public function setDataline($dataline)
    {
        $this->dataline = $dataline;
    
        return $this;
    }

    /**
     * Get dataline
     *
     * @return string 
     */
    public function getDataline()
    {
        return $this->dataline;
    }

    /**
     * Set power
     *
     * @param string $power
     * @return Assets
     */
    public function setPower($power)
    {
        $this->power = $power;
    
        return $this;
    }

    /**
     * Get power
     *
     * @return string 
     */
    public function getPower()
    {
        return $this->power;
    }

    /**
     * Set battery
     *
     * @param string $battery
     * @return Assets
     */
    public function setBattery($battery)
    {
        $this->battery = $battery;
    
        return $this;
    }

    /**
     * Get battery
     *
     * @return string 
     */
    public function getBattery()
    {
        return $this->battery;
    }

    /**
     * Set earline
     *
     * @param string $earline
     * @return Assets
     */
    public function setEarline($earline)
    {
        $this->earline = $earline;
    
        return $this;
    }

    /**
     * Get earline
     *
     * @return string 
     */
    public function getEarline()
    {
        return $this->earline;
    }

    /**
     * Set guarantee
     *
     * @param string $guarantee
     * @return Assets
     */
    public function setGuarantee($guarantee)
    {
        $this->guarantee = $guarantee;
    
        return $this;
    }

    /**
     * Get guarantee
     *
     * @return string 
     */
    public function getGuarantee()
    {
        return $this->guarantee;
    }

    /**
     * Set other
     *
     * @param string $other
     * @return Assets
     */
    public function setOther($other)
    {
        $this->other = $other;
    
        return $this;
    }

    /**
     * Get other
     *
     * @return string 
     */
    public function getOther()
    {
        return $this->other;
    }

    /**
     * Set department
     *
     * @param string $department
     * @return Assets
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
     * Set owner
     *
     * @param string $owner
     * @return Assets
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
     * Set whouse
     *
     * @param string $whouse
     * @return Assets
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
     * Set returnTime
     *
     * @param \DateTime $returnTime
     * @return Assets
     */
    public function setReturnTime($returnTime)
    {
        $this->returnTime = $returnTime;
    
        return $this;
    }

    /**
     * Get returnTime
     *
     * @return \DateTime 
     */
    public function getReturnTime()
    {
        return $this->returnTime;
    }

    /**
     * Set returnState
     *
     * @param string $returnState
     * @return Assets
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
     * Set note
     *
     * @param string $note
     * @return Assets
     */
    public function setNote($note)
    {
        $this->note = $note;
    
        return $this;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set operator
     *
     * @param string $operator
     * @return Assets
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

    /**
     * Set updateTime
     *
     * @param \DateTime $updateTime
     * @return Assets
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;
    
        return $this;
    }

    /**
     * Get updateTime
     *
     * @return \DateTime 
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * Set createTime
     *
     * @param \DateTime $createTime
     * @return Assets
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;
    
        return $this;
    }

    /**
     * Get createTime
     *
     * @return \DateTime 
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * Set fetchTime
     *
     * @param \DateTime $fetchTime
     * @return Assets
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
}