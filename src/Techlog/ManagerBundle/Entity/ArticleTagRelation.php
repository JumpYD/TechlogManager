<?php

namespace Techlog\ManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArticleTagRelation
 *
 * @ORM\Table(name="article_tag_relation")
 * @ORM\Entity
 */
class ArticleTagRelation
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
     * @var integer
     *
     * @ORM\Column(name="article_id", type="integer", nullable=false)
     */
    private $articleId;

    /**
     * @var integer
     *
     * @ORM\Column(name="tag_id", type="integer", nullable=false)
     */
    private $tagId;

    /**
     * @var string
     *
     * @ORM\Column(name="inserttime", type="string", nullable=false)
     */
    private $inserttime;


}
