<?php

namespace Techlog\ManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tags
 *
 * @ORM\Table(name="tags")
 * @ORM\Entity
 */
class Tags
{
    /**
     * @var integer
     *
     * @ORM\Column(name="tag_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $tagId;

    /**
     * @var string
     *
     * @ORM\Column(name="tag_name", type="string", length=200, nullable=true)
     */
    private $tagName;

    /**
     * @var string
     *
     * @ORM\Column(name="inserttime", type="string", nullable=false)
     */
    private $inserttime;


}
