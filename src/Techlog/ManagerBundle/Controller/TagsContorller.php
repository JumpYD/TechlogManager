<?php
namespace Techlog\ManagerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Techlog\ManagerBundle\Entity\Tags;

/**
 * @Route("/tags")
 */
class TagsContorller extends Controller
{
    private $input_list = array();
    private $range_list = array();
	private $select_list = array();
    private $key_value_map = array();

    /**
     * @Route("/list", name="techlog_manager_tags_list");
	 * @Template("TechlogManagerBundle:Tags:list.html.twig")
     */
    public function listAction (Request $request)
    {
        return $this->getQueryParams($request);
	}

    private function getQueryParams($request)
    {
        $params_key = $this->get_keys();
        $params = $this->getParams($request, $params_key);

		if ($this->getUser()->getUserName() != 'admin')
			$params['root'] = 0;
		else
			$params['root'] = 1;
		
        if (!isset($params['sortby']))
            $params['sortby'] = 'article_id';
        if (!isset($params['asc']))
            $params['asc'] = '1';

        $start = (int)$request->get("start");
        $limit = (int)$request->get("limit");

        $start = $start <= 0 ? 1 : $start;
        $limit = ($limit <= 0 or $limit > 1000) ? 20 : $limit;

        $repository_key = $this->get_repository_key();

        $em = $this->getDoctrine()->getEntityManager();
		list($total, $data) = $em->getRepository('TechlogManagerBundle:Article')->getList($start, $limit, $params, $repository_key);

        $totalPages = (int)(($total + $limit - 1) / $limit);

		return array (
            'sortby' => $params['sortby'],
            'asc' => $params['asc'],
            'data'  => $data,
            'total' => $total,
            'start' => $start,
            'limit' => $limit,
            'totalPages' => $totalPages,
            'select_list' => $this->select_list,
            'input_list' => $this->input_list,
            'key_value_map' => $this->key_value_map,
            'range_list' => $this->range_list,
            'params' => $params,
            'params_key' => $params_key,
		);
	}

    private function get_repository_key()
    {
        $repository_key = array();
        $repository_key['like_list'] = array_diff($this->input_list, array('article_id'));
        $repository_key['equal_list'] = array_merge(array_keys($this->select_list), array('article_id'));
        $repository_key['range_list'] = $this->range_list;

        return $repository_key;
    }

    private function get_keys()
    {
        $params_key = $this->input_list;
        foreach ($this->range_list as $value)
        {
            $params_key[] = 'start_'.$value;
            $params_key[] = 'end_'.$value;
        }
        $params_key = array_merge($params_key, array_keys($this->select_list), array('asc', 'sortby'));
        return $params_key;
    }

    private function getParams($request, $params)
    {
        foreach($params as $count=>$key)
        {
            $value = $request->get($key);
            if($value != NULL)
                $param[$key] = $value;
        }
        return $param;
    }
}
?>
