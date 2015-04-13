<?php

namespace Qihoo\ToolBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Qihoo\ToolBundle\Entity\QihooEmailGroup;
use Qihoo\ToolBundle\Entity\QihooEmailMember;
use Component\Exception\ParamException;
use Doctrine\DBAL\DBALException;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/email")
 */
class EmailController extends Controller
{
    /**
     * @Route("/list", name="tool_email_list")
     * @Template("QihooToolBundle:Email:list.html.twig")
     */
    public function listAction()
    {
        //$emailGroupFetcher = $this->get('email_group_fetcher');
        //$groups = $emailGroupFetcher->getEmailGroups();
        //$groupId = 4;
        //$members = $emailGroupFetcher->getGroupMembers($groupId);
        //var_dump($groups,$members);exit;
        $p = 1;
        $pn = 20;
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('QihooToolBundle:QihooEmailGroup')->getList($p, $pn);
        $total = count($entities);

        $totalPages = ceil($total / $pn);
        
        return array(
            "total" => $total,
            "totalPages" => $totalPages,
            "p" => $p,
            "pn" => $pn,
            "entities" => $entities,
        );
    }

    /**
     * @Route("/modify_group", name="tool_email_modifygroup")
     */
    public function modifyGroupAction()
    {
        $groupId = $this->getRequest()->get('group_id');
        $groupName = $this->getRequest()->get('group_name');
        $groupComment = $this->getRequest()->get('group_comment');
        $entity = $this->getDoctrine()
            ->getRepository('QihooToolBundle:QihooEmailGroup')
            ->findOneByGroupId($groupId);
        $entity->setGroupName($groupName);
        $entity->setGroupComment($groupComment);
        $entity->setUpdateTime(new \DateTime());
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($entity);
        $em->flush();
        $response = $this->forward(
            'QihooToolBundle:Email:modify',
            array(
                'group_id'=>$groupId,
                'member_name'=>'',
                'email'=>'',
                'phone'=>'',
            )
        );
        return $response;
    }

    /**
     * @Route("/modify_member", name="tool_email_modifymember")
     */
    public function modifyMemberAction()
    {
        $memberId = $this->getRequest()->get('member_id');
        $memberName = $this->getRequest()->get('member_name');
        $email = trim($this->getRequest()->get('email'));
        $phone = trim($this->getRequest()->get('phone'));
        if(empty($memberId) || empty($memberName) || empty($email)) {
            throw new Exception('Invalid Parameters');
        }
        $entity = $this->getDoctrine()
            ->getRepository('QihooToolBundle:QihooEmailMember')
            ->findOneByMemberId($memberId);
        $entity->setMemberName($memberName);
        $entity->setEmail($email);
        $entity->setPhone($phone);
        $entity->setUpdateTime(new \DateTime());
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($entity);
        $em->flush();
        $response = $this->forward(
            'QihooToolBundle:Email:modify',
            array(
                'group_id'=>$entity->getGroupId(),
                'member_name' => '',
                'email' => '',
                'phone' => '',
            )
        );
        return $response;
    }

    /**
     * @Route("/show_member", name="tool_email_showmember")
     * @Template("QihooToolBundle:Email:modify_member.html.twig")
     */
    public function showMemberAction()
    {
        $groupId = $this->getRequest()->get('group_id');
        $memberId = $this->getRequest()->get('member_id');
        if (empty($groupId) || empty($memberId)) {
            throw new Exception('Group ID OR Member ID Absent');
        }
        $entity = $this->getDoctrine()
            ->getRepository('QihooToolBundle:QihooEmailMember')
            ->findOneByMemberId($memberId);
        return array('entity'=>$entity);
    }

    /**
     * @Route("/modify", name="tool_email_modify")
     * @Template("QihooToolBundle:Email:modify.html.twig")
     */
    public function modifyAction()
    {
        $request = $this->getRequest();
        $params = $this->getQueryParams($request);
        
        if (empty($params['group_id'])) {
            $response = $this->forward('QihooToolBundle:Email:list', array());
            return $response;
        }

        $members = $this->getDoctrine()
            ->getRepository('QihooToolBundle:QihooEmailMember')
            ->query(1, 1000, array('group_id'=>$params['group_id']));
        $groupInfo = $this->getDoctrine()
            ->getRepository('QihooToolBundle:QihooEmailGroup')
            ->query(1, 1, array('group_id'=>$params['group_id']));
        $groupInfo = array(
            'group_id' => $groupInfo[0]->getGroupId(),
            'group_name' => $groupInfo[0]->getGroupName(),
            'group_comment' => $groupInfo[0]->getGroupComment(),
        );

        if (empty($params['member_name']) || empty($params['email'])) {
            return array(
                'error'  => '',
                'group' => $groupInfo,
                'members'=> $members,
            );
        }
        if (empty($params['phone'])) {
            $params['phone'] = '';
        }
        $entity = new QihooEmailMember();

        $queryParams = array(
            'email' => $params['email'],
            'group_id' => $params['group_id']
        );
        $group = $this->getDoctrine()->getManager()
            ->getRepository('QihooToolBundle:QihooEmailMember')
            ->query(1, 1, $queryParams);
        if (! empty($group)) {
            return array(
                'error'  => '此用户已存在邮件组中',
                'group' => $groupInfo,
                'members'=> $members,
            );
        }

        $entity->setMemberName($params['member_name']);
        $entity->setGroupId($params['group_id']);
        $entity->setEmail($params['email']);
        $entity->setPhone($params['phone']);
        $entity->setCreateTime(new \DateTime());
        $entity->setUpdateTime(new \DateTime());
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($entity);
        $em->flush();
        $response = $this->forward(
            'QihooToolBundle:Email:modify',
            array(
                'group_id'=>$params['group_id'],
                'member_name'=>'',
                'email'=>'',
                'phone'=>'',
            )
        );
        return $response;
    }

    /**
     * @Route("/query", name="tool_email_query")
     * @Template("QihooToolBundle:Email:query_result.html.twig")
     */
    public function queryAction()
    {
        $request = $this->getRequest();
        $queryParams = $this->getQueryParams($request);
        $p = (int)$request->get("p");
        $p = ($p <= 0) ? 1 : $p;
        $pn = (int)$request->get("pn");
        $pn = ($pn <= 0) ? 20 : $pn;
        $em = $this->getDoctrine()->getManager("sjbb");
        $entities = $em->getRepository('QihooToolBundle:QihooEmailGroup')
            ->query($p, $pn, $queryParams);
        $total = count($entities);
        $totalPages = ceil($total / $pn);
        return array(
            'total' => $total,
            'totalPages' => $totalPages,
            'p' => $p,
            'pn' => $pn,
            'entities' => $entities,
        );
    }

    /**
     * @Route("/add_group", name="tool_email_addgroup")
     * @Template("QihooToolBundle:Email:add_group.html.twig")
     */
    public function addGroupAction()
    {
        $request = $this->getRequest();
        $params = $this->getQueryParams($request);
        if (empty($params['group_name']) || empty($params['group_comment'])) {
            return array('error' => '');
        }
        $entity = new QihooEmailGroup();

        $queryParams = array(
            'group_name' => $params['group_name'],
        );
        $group = $this->getDoctrine()->getManager()
            ->getRepository('QihooToolBundle:QihooEmailGroup')
            ->query(1, 1, $queryParams);
        if (! empty($group)) {
            return array('error' => '邮件组已存在');
        }

        $entity->setGroupName($params['group_name']);
        $entity->setGroupComment($params['group_comment']);
        $entity->setCreateTime(new \DateTime());
        $entity->setUpdateTime(new \DateTime());
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($entity);
        $em->flush();
        $response = $this->forward('QihooToolBundle:Email:list');
        return $response;
    }

    /**
     * @Route("/member_delete", name="tool_email_memberdelete")
     */
    public function memberDeleteAction()
    {
        $request = $this->getRequest();
        $memberId = $request->get('member_id');
        $groupId = $request->get('group_id');
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('QihooToolBundle:QihooEmailMember')->query(1,1,array('member_id'=>$memberId));
        if (empty($entities[0])) {
            throw new ParamException("can not find member_id ($memberId)");
        }
        $entity = $entities[0];
        $em->remove($entity);
        $em->flush();
        $response = $this->forward(
            'QihooToolBundle:Email:modify',
            array(
                'group_id'=>$groupId,
            )
        );
        return $response;
    }

    private function getQueryParams($request)
    {
        $queryParams = array();
        $groupId = $request->get("group_id");
        if (! empty($groupId)) {
            $queryParams['group_id'] = $groupId;
        }
        $groupName = $request->get("group_name");
        if (! empty($groupName)) {
            $queryParams['group_name'] = $groupName;
        }
        $groupComment = $request->get("group_comment");
        if (! empty($groupComment)) {
            $queryParams['group_comment'] = $groupComment;
        }
        $memberName = $request->get("member_name");
        if (! empty($memberName)) {
            $queryParams['member_name'] = $memberName;
        }
        $email = trim($request->get("email"));
        if (! empty($email)) {
            $queryParams['email'] = $email;
        }
        $phone = trim($request->get("phone"));
        if (! empty($phone)) {
            $queryParams['phone'] = $phone;
        }
        return $queryParams;
    }
}
