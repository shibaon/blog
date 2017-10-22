<?php

namespace Kh\ContentBundle\Controller;

use Kh\BaseBundle\Controller\Controller;
use Svi\BaseBundle\Utils\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Svi\Exception\NotFoundHttpException;

class CategoryController extends Controller
{

	public function indexAction($id, Request $request)
	{
		if (!($category = $this->c->getContentBundle()->getCategoryService()->getCategory($id))) {
			throw new NotFoundHttpException;
		}

		$paginator = new Paginator($this->c->getContentBundle()->getPostService()->getPostsCount($category), 10, $request);
		$posts = $this->c->getContentBundle()->getPostService()->getPosts($category, null, $paginator->getCurrentPage(), $paginator->getItemsPerPage());

		$category->setPostsCount($paginator->getTotalItems());
		$this->c->getContentBundle()->getCategoryManager()->save($category);

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