<?php

namespace Kh\ContentBundle\Controller;

use Kh\BaseBundle\Controller\Controller;
use Sv\BaseBundle\Utils\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{

	public function indexAction($id, Request $request)
	{
		if (!($category = $this->c->getCategoryManager()->getCategory($id))) {
			throw new NotFoundHttpException;
		}

		$paginator = new Paginator($this->c->getPostManager()->getPostsCount($category), 10, $request);
		$posts = $this->c->getPostManager()->getPosts($category, null, $paginator->getCurrentPage(), $paginator->getItemsPerPage());

		$category->setPostsCount($paginator->getTotalItems())->save();

		return $this->render('index', $this->getTemplateParameters([
			'posts' => array(
				'items' => $posts,
				'pages' => $paginator->getView(),
			),
			'count' => $paginator->getTotalItems(),
			'category' => $category,
		]));
	}

}