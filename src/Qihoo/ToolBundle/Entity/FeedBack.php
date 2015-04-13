<?php

namespace Qihoo\ToolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 问题反馈表
 * @author wukai
 * @ORM\Entity(repositoryClass="Qihoo\ToolBundle\Repository\FeedBackRepository")
 * @ORM\Table(name="qihoo_feedback")
 */
class FeedBack
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
    private $version;

    /**
     * @ORM\Column(type="text")
     */
    private $question;

    /**
     * @ORM\Column(type="integer")
     */
    private $state;

    /**
     * @ORM\Column(type="text")
     */
    private $process;

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
     * Set question
     *
     * @param string $question
     * @return FeedBack
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    
        return $this;
    }

    /**
     * Get question
     *
     * @return string 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set state
     *
     * @param integer $state
     * @return FeedBack
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return integer 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set process
     *
     * @param string $process
     * @return FeedBack
     */
    public function setProcess($process)
    {
        $this->process = $process;
    
        return $this;
    }

    /**
     * Get process
     *
     * @return string 
     */
    public function getProcess()
    {
        return $this->process;
    }

    /**
     * Set operator
     *
     * @param string $operator
     * @return FeedBack
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
     * @return FeedBack
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
     * @return FeedBack
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
     * Set version
     *
     * @param string $version
     * @return FeedBack
     */
    public function setVersion($version)
    {
        $this->version = $version;
    
        return $this;
    }

    /**
     * Get version
     *
     * @return string 
     */
    public function getVersion()
    {
        return $this->version;
    }
}