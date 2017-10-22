<?php

namespace Kh\PromoBundle\Controller;

use Kh\BaseBundle\Controller\Controller;
use Svi\BaseBundle\Utils\Paginator;
use Symfony\Component\HttpFoundation\Request;

class FrontController extends Controller
{

	public function indexAction(Request $request)
	{
		$search = $request->query->has('search') ? $request->query->get('search') : null;

		$paginator = new Paginator($this->c->getContentBundle()->getPostService()->getPostsCount(null, $search), 10, $request);

		return $this->render('index', $this->getTemplateParameters([
			'posts' => array(
				'pages' => $paginator->getView(),
				'items' => $this->c->getContentBundle()->getPostService()
					->getPosts(null, $search, $paginator->getCurrentPage(), $paginator->getItemsPerPage()),
			),
			'count' => $paginator->getTotalItems(),
			'search' => $search,
		]));
	}

} 