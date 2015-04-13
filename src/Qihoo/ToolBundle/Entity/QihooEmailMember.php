<?php

namespace Qihoo\ToolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QihooEmailMember
 * @author chenhong3
 * @ORM\Table(name="qihoo_email_member")
 * @ORM\Entity(repositoryClass="Qihoo\ToolBundle\Repository\QihooEmailMemberRepository")
 */
class QihooEmailMember
{
    /**
     * @var integer
     *
     * @ORM\Column(name="member_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $memberId;

    /**
     * @var string
     *
     * @ORM\Column(name="member_name", type="string", length=255)
     */
    private $memberName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var integer
     *
     * @ORM\Column(name="group_id", type="integer")
     */
    private $groupId;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

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
     * Set memberId
     *
     * @param integer $memberId
     * @return QihooEmailMember
     */
    public function setMemberId($memberId)
    {
        $this->memberId = $memberId;
    
        return $this;
    }

    /**
     * Get memberId
     *
     * @return integer 
     */
    public function getMemberId()
    {
        return $this->memberId;
    }

    /**
     * Set memberName
     *
     * @param string $memberName
     * @return QihooEmailMember
     */
    public function setMemberName($memberName)
    {
        $this->memberName = $memberName;
    
        return $this;
    }

    /**
     * Get memberName
     *
     * @return string 
     */
    public function getMemberName()
    {
        return $this->memberName;
    }

    /**
     * Set Email
     *
     * @param string $Email
     * @return QihooEmailMember
     */
    public function setEmail($Email)
    {
        $this->email = $Email;
    
        return $this;
    }

    /**
     * Get Email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set groupId
     *
     * @param integer $groupId
     * @return QihooEmailMember
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
     * Set phone
     *
     * @param string $phone
     * @return QihooEmailMember
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
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
