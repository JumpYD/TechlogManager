<?php

namespace Qihoo\ToolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QihooEmailGroup
 * @author chenhong3
 * @ORM\Table(name="qihoo_email_group")
 * @ORM\Entity(repositoryClass="Qihoo\ToolBundle\Repository\QihooEmailGroupRepository")
 */
class QihooEmailGroup
{
    /**
     * @var integer
     *
     * @ORM\Column(name="group_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $groupId;

    /**
     * @var string
     *
     * @ORM\Column(name="group_name", type="string", length=255)
     */
    private $groupName;

    /**
     * @var string
     *
     * @ORM\Column(name="group_comment", type="string", length=255)
     */
    private $groupComment;

    /**
     * @ORM\Column(name="create_time", type="datetime")
     */
    private $createTime;

    /**
     * @ORM\Column(name="update_time", type="datetime")
     */
    private $updateTime;

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
     * Set groupId
     *
     * @param integer $groupId
     * @return QihooEmailGroup
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
    
        return $this;
    }

    /**
     * Get groupId
     *
     * @return integer 
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * Set groupName
     *
     * @param string $groupName
     * @return QihooEmailGroup
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;
    
        return $this;
    }

    /**
     * Get groupName
     *
     * @return string 
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * Set groupComment
     *
     * @param string $groupComment
     * @return QihooEmailGroup
     */
    public function setGroupComment($groupComment)
    {
        $this->groupComment = $groupComment;
    
        return $this;
    }

    /**
     * Get groupComment
     *
     * @return string 
     */
    public function getGroupComment()
    {
        return $this->groupComment;
    }

    /**
     * Set createTime
     *
     * @param \DateTime $createTime
     * @return QihooEmailGroup
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
     * Set updateTime
     *
     * @param \DateTime $updateTime
     * @return QihooEmailGroup
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
}
