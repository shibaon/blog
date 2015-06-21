<?php

namespace Kh\PromoBundle\Controller;

use Kh\BaseBundle\Controller\Controller;
use Sv\BaseBundle\Utils\Paginator;
use Symfony\Component\HttpFoundation\Request;

class FrontController extends Controller
{

	public function indexAction(Request $request)
	{
		$search = $request->query->has('search') ? $request->query->get('search') : null;

		$paginator = new Paginator($this->c->getPostManager()->getPostsCount(null, $search), 10, $request);

		return $this->render('index', $this->getTemplateParameters([
			'posts' => array(
				'pages' => $paginator->getView(),
				'items' => $this->c->getPostManager()->getPosts(null, $search, $paginator->getCurrentPage(), $paginator->getItemsPerPage()),
			),
			'count' => $paginator->getTotalItems(),
			'search' => $search,
		]));
	}

} 