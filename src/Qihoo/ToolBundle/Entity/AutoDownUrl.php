<?php
namespace Qihoo\ToolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Qihoo\ToolBundle\Repository\AutoDownUrlRepository")
 * @ORM\Table(name="task_autodownurl")
 */
class AutoDownUrl {

    public function __construct($url) {
        $this->url = $url;
        $this->state = 0;
        $this->startTime = new \DateTime();
        $this->endTime = NULL;
        $this->msg = "未开始";
    }
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $url;
    /**
     * @ORM\Column(type="integer")
     */
    private $state; //0,未开始；1，进行中；2，已结束
    /**
     * @ORM\Column(type="datetime", name="start_time")
     */
    private $startTime;

    /**
     * @ORM\Column(type="datetime", name="end_time")
     */
    private $endTime;

    /**
     * @ORM\Column(type="string")
     */
    private $msg;

    public function __toString() {
        return $this->url;
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
     * Set url
     *
     * @param string $url
     * @return AutoDownUrl
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set state
     *
     * @param integer $state
     * @return AutoDownUrl
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
     * Set startTime
     *
     * @param \DateTime $startTime
     * @return AutoDownUrl
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     * @return AutoDownUrl
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set msg
     *
     * @param string $msg
     * @return AutoDownUrl
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;

        return $this;
    }

    /**
     * Get msg
     *
     * @return string
     */
    public function getMsg()
    {
        return $this->msg;
    }
}
